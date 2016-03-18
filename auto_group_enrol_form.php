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
 * Displays form
 *
 * @package    tool_groupautoenrol
 * @copyright  2016 Pascal
 * @author     Pascal M - https://github.com/pascal-my
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
require_once("$CFG->libdir/formslib.php");

/**
 * Displays form
 *
 * @param object $mform
 * @param object $page
 * @param object $course
 * @return nothing
 */
function auto_group_enrol_form(MoodleQuickForm $mform, $page, $course) {
    global $CFG, $USER, $DB;

    $mform->addElement('header', 'enrol', get_string('settings'));
    $data = array();
    $allgroupscourse = groups_get_all_groups($course->id);
    // Group(s) must be created first.
    if (count($allgroupscourse) == 0) {
        $mform->addElement('static', 'no_group_found', '', get_string('auto_group_enrol_form_no_group_found',
            'tool_groupautoenrol', (string)$course->id));
    } else {
        $instance = false;
        if ( isset($course->id) ) {
            $instance = $DB->get_record('tool_groupautoenrol', array('courseid' => $course->id));
        }

        $mform->addElement('checkbox', 'enable_enrol', get_string('auto_group_form_enable_enrol', 'tool_groupautoenrol'));
        if ($instance != false) {
            $enableenrol = $instance->enable_enrol;
        } else {
            $enableenrol = 0;
        }
        $mform->setDefault('enable_enrol', $enableenrol);

        $mform->addElement('checkbox', 'use_groupslist', get_string('auto_group_form_usegroupslist', 'tool_groupautoenrol'));
        if ($instance != false) {
            $usegroupslist = $instance->use_groupslist;
        } else {
            $usegroupslist = 0;
        }
        $mform->setDefault('use_groupslist', $usegroupslist);
        $mform->disabledIf('use_groupslist', 'enable_enrol');

        $fields = array();
        foreach ($allgroupscourse as $group) {
            $fields[$group->id] = $group->name;
        }
        $select = $mform->addElement('select', 'groupslist', get_string('auto_group_form_groupslist',
            'tool_groupautoenrol'), $fields);
        $select->setMultiple(true);
        $mform->disabledIf('groupslist', 'enable_enrol');
        $mform->disabledIf('groupslist', 'use_groupslist');
        if ($instance != false) {
            $mform->setDefault('groupslist', explode(",", $instance->groupslist));
        }
    }
}
