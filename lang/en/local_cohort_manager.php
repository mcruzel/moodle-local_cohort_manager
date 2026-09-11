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

$string['actions'] = 'Actions';
$string['add'] = 'Add';
$string['addtocohort'] = 'Add to cohort';
$string['backtocohortlist'] = 'Back to cohort list';
$string['batchrename'] = 'Rename all groups';
$string['batchrenameconfirm'] = 'Are you sure you want to rename all groups for this cohort? This action cannot be undone.';
$string['batchrenamedesc'] = 'Rename all groups associated with this cohort\'s enrolments to the same name. This affects all courses where this cohort is enrolled.';
$string['batchrenamegroups'] = 'Batch rename groups';
$string['cancel'] = 'Cancel';
$string['cannotmanagecohort'] = 'This cohort is managed by another component (\'{$a}\') and cannot be modified here.';
$string['cohort_manager:manage'] = 'Manage cohort deployments';
$string['cohort_manager:removeenrolment'] = 'Remove a cohort from a course';
$string['cohortdeleted'] = 'Cohort successfully deleted.';
$string['cohortidnumber'] = 'ID number';
$string['cohortname'] = 'Cohort name';
$string['cohortnamesection'] = 'Cohort name';
$string['cohortnotfound'] = 'Cohort not found.';
$string['cohortrenamed'] = 'Cohort successfully renamed.';
$string['cohortsforuser'] = 'Cohorts for user';
$string['componentmanagednotice'] = 'This cohort is managed by another component: it cannot be renamed or deleted here.';
$string['componentmanagedshort'] = 'Managed by another component';
$string['confirmdelete'] = 'Delete permanently';
$string['confirmremoveenrolment'] = 'Remove from this course';
$string['coursename'] = 'Course name';
$string['courseshortname'] = 'Short name';
$string['creategroup'] = 'Create group';
$string['deletecohort'] = 'Delete cohort';
$string['deletenamenotmatch'] = 'The name you entered does not match the cohort name. Deletion cancelled.';
$string['deletetypename'] = 'To confirm, type the exact name of the cohort below:';
$string['deletetypeplaceholder'] = 'Type cohort name here...';
$string['deletewarning'] = 'This action is irreversible. The cohort and all its member associations will be permanently deleted.';
$string['description'] = 'Description';
$string['email'] = 'Email';
$string['emptycohortname'] = 'Cohort name cannot be empty.';
$string['emptygroupname'] = 'Group name cannot be empty.';
$string['enrolcount'] = 'Enrolments';
$string['enrolledcourses'] = 'Enrolled courses';
$string['enrolmentdeleted'] = 'The cohort enrolment method was removed from the course.';
$string['enrolmentdeletedgroupshared'] = 'The cohort enrolment method was removed from the course. Its linked group was kept: another synchronised enrolment method of that course also fills it.';
$string['enrolmentdeletedwithgroup'] = 'The cohort enrolment method and its linked group were removed from the course.';
$string['enrolpluginmissing'] = 'The cohort enrolment plugin is not installed on this site.';
$string['eventcohortrenamed'] = 'Cohort renamed';
$string['eventenrolmentdeleted'] = 'Cohort enrolment removed from a course';
$string['eventgrouprenamed'] = 'Group renamed';
$string['eventgroupsbatchrenamed'] = 'Groups batch renamed';
$string['fullname'] = 'Full name';
$string['groupalreadyexists'] = 'A group is already linked to this enrolment method.';
$string['groupcreated'] = 'Group successfully created and linked to the enrolment method.';
$string['groupname'] = 'Group name';
$string['grouprenamed'] = 'Group successfully renamed.';
$string['groupsbatchrenamed'] = 'All groups successfully renamed.';
$string['invalidaction'] = 'Invalid action.';
$string['keepgroup'] = 'Do not delete the linked group';
$string['keepgroupdesc'] = 'Leave this unticked to delete the group as well. Either way the group loses the members it held through this cohort, because Moodle removes the memberships the enrolment method created.';
$string['membercount'] = 'Members';
$string['newgroupname'] = 'New group name';
$string['nocohortsfound'] = 'No cohorts found.';
$string['noenrolments'] = 'This cohort is not enrolled in any course.';
$string['nogroup'] = 'No group';
$string['pluginname'] = 'Cohort Manager';
$string['privacy:metadata'] = 'The Cohort Manager plugin does not store any personal data.';
$string['remove'] = 'Remove';
$string['removeconfirm'] = 'Are you sure you want to remove this user from this cohort?';
$string['removeenrolment'] = 'Remove the cohort from this course';
$string['removeenrolmentconsequence1'] = 'The cohort enrolment method is deleted from the course: the cohort no longer feeds it.';
$string['removeenrolmentconsequence2'] = 'Every user enrolled by this method is unenrolled from the course and loses the roles it granted them.';
$string['removeenrolmentconsequence3'] = 'For users whose only enrolment in the course was this method, Moodle also discards what it discards on any unenrolment: their grades in this course, their group memberships and their last access record.';
$string['removeenrolmentconsequence4'] = 'Re-creating the enrolment method afterwards enrols those users again, but does not bring back the deleted data — old grades only come back if the site is set to recover them on re-enrolment.';
$string['removeenrolmentcourse'] = 'Course concerned:';
$string['removeenrolmentgroup'] = 'Group linked to this enrolment:';
$string['removeenrolmentshort'] = 'S';
$string['removeenrolmentusers'] = 'Users enrolled in the course by this method:';
$string['removeenrolmentwarning'] = 'This action is irreversible and affects real user data.';
$string['rename'] = 'Rename';
$string['renamecohort'] = 'Rename cohort';
$string['restrictcohortplaceholder'] = 'e.g. a promotion year...';
$string['restrictcohortsearch'] = 'Restrict to';
$string['search'] = 'Search';
$string['searchcohortplaceholder'] = 'Search for a cohort...';
$string['searchplaceholder'] = 'Search cohorts by name, ID number or description...';
$string['searchuser'] = 'Search user';
$string['searchuserplaceholder'] = 'Search by name, email or username...';
$string['selectcohort'] = '-- Select a cohort --';
$string['selecteduser'] = 'Selected';
$string['selectuser'] = 'Select';
$string['useraddedtocohort'] = 'User successfully added to cohort.';
$string['usercohorts'] = 'User cohorts';
$string['username'] = 'Username';
$string['usernomemberships'] = 'This user does not belong to any cohort.';
$string['userremovedfromcohort'] = 'User successfully removed from cohort.';
$string['viewdetails'] = 'View details';
