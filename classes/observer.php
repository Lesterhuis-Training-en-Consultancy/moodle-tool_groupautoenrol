<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Event observers used in tool_groupautoenrol.
 *
 * @package    tool_groupautoenrol
 * @copyright  2016 Pascal
 * @author     Pascal M - https://github.com/pascal-my
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Event observer for tool_groupautoenrol.
 */
class tool_groupautoenrol_observer {

    /**
     * Triggered via core\event\user_enrolment_created (user_enrolled)
     * Action when user is enrolled
     *
     * @param \core\event\user_enrolment_created $event
     * @return bool true if all ok
     */
    public static function user_is_enrolled(\core\event\user_enrolment_created $event) {
        global $CFG, $USER, $DB;
        require_once($CFG->dirroot.'/group/lib.php');
        $enroldata = $event->get_record_snapshot($event->objecttable, $event->objectid);
        $groupautoenrol = $DB->get_record('tool_groupautoenrol', array('courseid' => $event->courseid));
        if (isset($groupautoenrol) &&  // Could be removed ?
			($groupautoenrol != false) && // If the plugin has never been actived, the record does not exist and $groupautoenrol = false.
				($groupautoenrol->enable_enrol == "1")) { // Plugin is actived for this course.
            $enrol = $DB->get_record('enrol', array('id' => $enroldata->enrolid), "roleid");
            if ($groupautoenrol->use_groupslist == "1") {
                // If use_groupslist == 1, we need to check.
                // a) if the list is not empty.
                if ($groupautoenrol->groupslist != "") {
                    $groupstemp = explode(",", $groupautoenrol->groupslist);
                    // b) if the listed groups still exists (because when a group is deleted, groupautoenrol table is not updated !).
                    $allgroupscourse = groups_get_all_groups($event->courseid);
                    $groupstouse = array();
                    foreach ($groupstemp as $group) {
                        if (isset($allgroupscourse[$group])) {
                            $groupstouse[] = $allgroupscourse[$group];
                        }
                    }
                } else { // Empty array is returned.
                    $groupstouse = array();
                }
            } else { // If use_groupslist == 0, use all groups course.
                $groupstouse = groups_get_all_groups($event->courseid);
            }

            // Checking if there is at least 1 group
            if (count($groupstouse) > 0) {
                // Checking if user is not already into theses groups
                $alreadymember = false;
                foreach ($groupstouse as $group) {
                    if ( groups_is_member($group->id, $enroldata->userid )) {
                        $alreadymember = true;
                    }
                }
                if (!$alreadymember) {
                    if ($groupautoenrol->enrol_method == "1") { // 0 = random, 1 = alpha, 2 = balanced.
                        foreach ($groupstouse as $group) {
                            $groupname = $group->name;
                            if (( $groupname[strlen($groupname) - 2] <= $USER->lastname[0] )
                            && ( $groupname[strlen($groupname) - 1] >= $USER->lastname[0] )) {
                                groups_add_member($group->id, $enroldata->userid);
                                break; // exit foreach (is it working ?)
                            }
                        }
                    } else {
                        // array_rand return key not value !
                        $randkeys = array_rand($groupstouse);
                        $group2add = $groupstouse[$randkeys];
                        groups_add_member($group2add, $enroldata->userid);
                    }
                }
            }
        }
        return true;
    }
}
