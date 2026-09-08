# Cohort Manager #

[![Moodle 4.3 – 5.2](https://img.shields.io/badge/Moodle-4.3%E2%80%935.2-orange)](https://moodle.org)
[![Licence GPL v3+](https://img.shields.io/badge/licence-GPL%20v3%2B-blue)](https://www.gnu.org/licenses/gpl-3.0)

A Moodle local plugin that gives site managers a single place to audit and
maintain cohorts, the courses those cohorts are enrolled into, and the groups
attached to each of those enrolments.

Core Moodle lets you manage cohorts (*Site administration > Users > Cohorts*)
and groups (per course) in two unrelated places, with no view of how they line
up. Cohort Manager joins them: for a given cohort you see every course it is
enrolled into, whether each enrolment instance has a group, and you can rename
or create those groups — individually or in bulk — without visiting each course.

> **Maturity: alpha.** This release is flagged `MATURITY_ALPHA` in
> `version.php`. Some operations (deleting a cohort, batch renaming groups)
> change data across many courses at once. Try it on a test site first, and
> take a database backup before using it in production.

## Features ##

**Cohort list** (`index.php`)

* Search cohorts by name, ID number or description.
* Sort by name, ID number, member count or enrolment count.
* Paginated, 50 cohorts per page.
* Shows, for each cohort, its number of members and the number of course
  enrolment instances using it, with a shortcut to the core member assignment
  page.

**Cohort detail** (`view.php`)

* Rename the cohort.
* Delete the cohort — guarded by a confirmation field in which the exact
  cohort name has to be retyped.
* List every `enrol_cohort` instance for the cohort, with its course and the
  group linked to that instance (if any).
* Create a group for an enrolment instance that has none. The group is named
  after the cohort, linked to the instance, and populated straight away with the
  users the instance enrols.
* Rename a single group.
* Batch rename every group linked to the cohort's enrolment instances, in one
  database transaction.

**User memberships** (`user.php`)

* Search users by name, email or username. Each result's username links to
  the user's profile page.
* Review the cohorts a selected user belongs to.
* Add the user to a cohort — the cohort picker is an AJAX autocomplete that
  only offers cohorts the user is not already a member of. A second,
  persistent filter field sits next to it and narrows those results down
  further, cumulatively with whatever is typed into the autocomplete — for
  example, entering a promotion year there restricts the autocomplete to
  cohorts whose name or ID number also matches that year.
* Remove the user from a cohort.

The plugin defines no database tables of its own. It reads and writes core
`cohort`, `groups` and `enrol` records through the core APIs
(`cohort_update_cohort`, `cohort_delete_cohort`, `groups_create_group`,
`groups_update_group`, `cohort_add_member`, `cohort_remove_member`).

## Requirements ##

* Moodle 4.3 (build 2023100900) to Moodle 5.2. The templates carry both the
  Bootstrap 4 and the Bootstrap 5 spelling of the utility classes they need, so
  they render on the Bootstrap 4 themes of Moodle 4.x and on the Bootstrap 5
  themes of Moodle 5.x without a version switch in PHP.
* PHP 8.0 or later (the floor of Moodle 4.3; Moodle 5.2 itself requires PHP 8.3).
* No additional PHP extensions or external services.

Since Moodle 5.1 the plugin installs under `public/local/cohort_manager` rather
than `local/cohort_manager`, following the web root moved to `public/`. No code
change is needed for this: `$CFG->dirroot` points at that directory.

> **On the 4.x range.** Compatibility with Moodle 4.3 to 4.5 was established by
> auditing the plugin against the `MOODLE_403_STABLE` and `MOODLE_502_STABLE`
> sources: every core function, class and template helper the plugin calls exists
> with the same signature across that range. It has not yet been exercised on a
> running 4.x site. Smoke-test it there before relying on it, and be aware that
> Moodle 4.3 and 4.4 are past their security-support window — 4.5 is the LTS of
> that series.

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to *Site administration >
   Plugins > Install plugins*.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can also be installed by putting the contents of this directory into

    {your/moodle/dirroot}/local/cohort_manager

The directory **must** be named `cohort_manager`, otherwise Moodle will refuse
to install the plugin.

Afterwards, log in to your Moodle site as an admin and go to *Site
administration > Notifications* to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Usage ##

Once installed, the plugin is reachable at *Site administration > Plugins >
Local plugins > Cohort Manager*, or directly at
`/local/cohort_manager/index.php`.

Every page requires the `local/cohort_manager:manage` capability in the system
context, so the entry is hidden from users who do not hold it.

## Capabilities ##

| Capability | Context | Risk | Granted by default to |
| --- | --- | --- | --- |
| `local/cohort_manager:manage` | System | `RISK_CONFIG` | Manager |

Grant it to other roles in *Site administration > Users > Permissions > Define
roles*. It is the only capability the plugin checks; there is no read-only
mode.

## Web services ##

| Function | Type | AJAX | Required capability |
| --- | --- | --- | --- |
| `local_cohort_manager_search_available_cohorts` | read | yes | `local/cohort_manager:manage` |

The function is called from the browser by the
`local_cohort_manager/cohort_selector` AMD module, which acts as the transport
for the core `core/form-autocomplete` field on the user memberships page. It is
not intended to be consumed by external clients and is not published in any
service.

## Events ##

The plugin triggers the following events, visible in the standard log report:

| Event | Object table | CRUD |
| --- | --- | --- |
| `\local_cohort_manager\event\cohort_renamed` | `cohort` | update |
| `\local_cohort_manager\event\group_renamed` | `groups` | update |
| `\local_cohort_manager\event\groups_batch_renamed` | `cohort` | update |

Cohort deletion and cohort membership changes are logged by the corresponding
core events, which the core APIs fire on the plugin's behalf.

## Privacy ##

The plugin implements `\core_privacy\local\metadata\null_provider`: it stores no
personal data of its own. All data it displays and modifies belongs to core
subsystems, which declare it in their own privacy providers.

## Language packs ##

English (`en`) and French (`fr`) are shipped with the plugin. Translations are
welcome — please do not edit the shipped files for site-specific wording, use
*Site administration > Language > Language customisation* instead.

## Security ##

Every entry point calls `require_login()` and enforces
`local/cohort_manager:manage` in the system context. The two write endpoints
(`action.php` and `useraction.php`) additionally call `require_sesskey()`, and
all forms post a session key, so the plugin's state-changing operations are not
reachable by CSRF.

## Notes and known limitations ##

* Creating a group for an enrolment instance links the new group to that
  instance (`enrol.customint2`) and then runs the core `enrol_cohort`
  synchronisation for the course, so users already enrolled by the instance
  become members without waiting for cron. When the `cohort` enrolment plugin is
  disabled, only `groups_sync_with_enrolment()` runs — a full sync would
  unassign every `enrol_cohort` role.
* Batch renaming gives every group linked to the cohort the same name. Moodle
  scopes group names per course, so this is valid, but it does mean two courses
  end up with identically named groups.
* Deleting a cohort calls the core `cohort_delete_cohort()` API and nothing
  more. The plugin does not remove the cohort enrolment instances that pointed
  at the cohort, nor the groups that were created for them — review those
  courses yourself after a deletion.

## Uninstalling ##

Go to *Site administration > Plugins > Plugins overview*, find **Cohort
Manager** in the list of local plugins and choose *Uninstall*. Since the plugin
owns no tables and stores no settings, nothing is left behind. The cohorts,
groups and enrolments it was used to manage are untouched.

## Licence ##

2026 Maxime Cruzel

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program. If not, see <https://www.gnu.org/licenses/>.
