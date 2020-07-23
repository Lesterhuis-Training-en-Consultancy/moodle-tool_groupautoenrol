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
 * Manage form
 *
 * @package    tool_groupautoenrol
 * @copyright  2016 Pascal
 * @author     Pascal M - https://github.com/pascal-my
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/formslib.php");
require_once('./auto_group_enrol_form.php');

/**
 * manage_auto_group_enrol_form class
 */
class manage_auto_group_enrol_form extends moodleform {

    /**
     * Definition
     */
    public function definition() {
        global $USER, $CFG, $DB;

        $mform = $this->_form;
        $page = $this->_customdata['page'];
        $course = $this->_customdata['course'];
        $context = $this->_customdata['context'];

        auto_group_enrol_form($mform, $page, $course, $context);

        $this->add_action_buttons();
    }
}
