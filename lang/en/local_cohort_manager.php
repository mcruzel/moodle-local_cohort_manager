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
 * English language strings for the Cohort Manager plugin.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Cohort Manager';
$string['cohortmanager:manage'] = 'Manage cohort deployments';

// Index page.
$string['searchplaceholder'] = 'Search cohorts by name, ID number or description...';
$string['search'] = 'Search';
$string['cohortname'] = 'Cohort name';
$string['cohortidnumber'] = 'ID number';
$string['actions'] = 'Actions';
$string['viewdetails'] = 'View details';
$string['nocohortsfound'] = 'No cohorts found.';

// Detail page.
$string['backtocohortlist'] = 'Back to cohort list';
$string['cohortnamesection'] = 'Cohort name';
$string['renamecohort'] = 'Rename cohort';
$string['enrolledcourses'] = 'Enrolled courses';
$string['coursename'] = 'Course name';
$string['courseshortname'] = 'Short name';
$string['groupname'] = 'Group name';
$string['newgroupname'] = 'New group name';
$string['rename'] = 'Rename';
$string['nogroup'] = 'No group';
$string['noenrolments'] = 'This cohort is not enrolled in any course.';

// Batch rename.
$string['batchrenamegroups'] = 'Batch rename groups';
$string['batchrenamedesc'] = 'Rename all groups associated with this cohort\'s enrolments to the same name. This affects all courses where this cohort is enrolled.';
$string['batchrename'] = 'Rename all groups';
$string['batchrenameconfirm'] = 'Are you sure you want to rename all groups for this cohort? This action cannot be undone.';

// Notifications.
$string['cohortrenamed'] = 'Cohort successfully renamed.';
$string['grouprenamed'] = 'Group successfully renamed.';
$string['groupsbatchrenamed'] = 'All groups successfully renamed.';

// Create group.
$string['creategroup'] = 'Create group';
$string['groupcreated'] = 'Group successfully created and linked to the enrolment method.';
$string['groupalreadyexists'] = 'A group is already linked to this enrolment method.';

// User cohort management.
$string['usercohorts'] = 'User cohorts';
$string['searchuser'] = 'Search user';
$string['searchuserplaceholder'] = 'Search by name, email or username...';
$string['username'] = 'Username';
$string['fullname'] = 'Full name';
$string['email'] = 'Email';
$string['selectuser'] = 'Select';
$string['selecteduser'] = 'Selected';
$string['cohortsforuser'] = 'Cohorts for user';
$string['addtocohort'] = 'Add to cohort';
$string['selectcohort'] = '-- Select a cohort --';
$string['add'] = 'Add';
$string['remove'] = 'Remove';
$string['removeconfirm'] = 'Are you sure you want to remove this user from this cohort?';
$string['useraddedtocohort'] = 'User successfully added to cohort.';
$string['userremovedfromcohort'] = 'User successfully removed from cohort.';
$string['usernomemberships'] = 'This user does not belong to any cohort.';

// Cohort list columns.
$string['description'] = 'Description';
$string['membercount'] = 'Members';
$string['enrolcount'] = 'Enrolments';
$string['searchcohortplaceholder'] = 'Search for a cohort...';

// Delete cohort.
$string['deletecohort'] = 'Delete cohort';
$string['deletewarning'] = 'This action is irreversible. The cohort and all its member associations will be permanently deleted.';
$string['deletetypename'] = 'To confirm, type the exact name of the cohort below:';
$string['deletetypeplaceholder'] = 'Type cohort name here...';
$string['cancel'] = 'Cancel';
$string['confirmdelete'] = 'Delete permanently';
$string['cohortdeleted'] = 'Cohort successfully deleted.';
$string['deletenamenotmatch'] = 'The name you entered does not match the cohort name. Deletion cancelled.';

// Errors.
$string['cohortnotfound'] = 'Cohort not found.';
$string['emptycohortname'] = 'Cohort name cannot be empty.';
$string['emptygroupname'] = 'Group name cannot be empty.';
$string['invalidaction'] = 'Invalid action.';

// Events.
$string['eventcohortrenamed'] = 'Cohort renamed';
$string['eventgrouprenamed'] = 'Group renamed';
$string['eventgroupsbatchrenamed'] = 'Groups batch renamed';

// Privacy.
$string['privacy:metadata'] = 'The Cohort Manager plugin does not store any personal data.';
