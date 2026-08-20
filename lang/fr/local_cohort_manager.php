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
 * French language strings for the Cohort Manager plugin.
 *
 * @package    local_cohort_manager
 * @copyright  2026 Maxime Cruzel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Gestionnaire de cohortes';
$string['cohort_manager:manage'] = 'Gérer les déploiements de cohortes';

// Page principale.
$string['searchplaceholder'] = 'Rechercher des cohortes par nom, identifiant ou description...';
$string['search'] = 'Rechercher';
$string['cohortname'] = 'Nom de la cohorte';
$string['cohortidnumber'] = 'Identifiant';
$string['actions'] = 'Actions';
$string['viewdetails'] = 'Voir les détails';
$string['nocohortsfound'] = 'Aucune cohorte trouvée.';

// Page de détail.
$string['backtocohortlist'] = 'Retour à la liste des cohortes';
$string['cohortnamesection'] = 'Nom de la cohorte';
$string['renamecohort'] = 'Renommer la cohorte';
$string['enrolledcourses'] = 'Cours inscrits';
$string['coursename'] = 'Nom du cours';
$string['courseshortname'] = 'Nom abrégé';
$string['groupname'] = 'Nom du groupe';
$string['newgroupname'] = 'Nouveau nom du groupe';
$string['rename'] = 'Renommer';
$string['nogroup'] = 'Aucun groupe';
$string['noenrolments'] = 'Cette cohorte n\'est inscrite dans aucun cours.';

// Renommage en lot.
$string['batchrenamegroups'] = 'Renommage des groupes en lot';
$string['batchrenamedesc'] = 'Renommer tous les groupes associés aux inscriptions de cette cohorte avec le même nom. Cela affecte tous les cours où cette cohorte est inscrite.';
$string['batchrename'] = 'Renommer tous les groupes';
$string['batchrenameconfirm'] = 'Êtes-vous sûr de vouloir renommer tous les groupes de cette cohorte ? Cette action est irréversible.';

// Notifications.
$string['cohortrenamed'] = 'Cohorte renommée avec succès.';
$string['grouprenamed'] = 'Groupe renommé avec succès.';
$string['groupsbatchrenamed'] = 'Tous les groupes ont été renommés avec succès.';

// Création de groupe.
$string['creategroup'] = 'Créer le groupe';
$string['groupcreated'] = 'Groupe créé et associé à la méthode d\'inscription avec succès.';
$string['groupalreadyexists'] = 'Un groupe est déjà associé à cette méthode d\'inscription.';

// Gestion des cohortes d'un utilisateur.
$string['usercohorts'] = 'Cohortes d\'un utilisateur';
$string['searchuser'] = 'Rechercher un utilisateur';
$string['searchuserplaceholder'] = 'Rechercher par nom, email ou identifiant...';
$string['username'] = 'Identifiant';
$string['fullname'] = 'Nom complet';
$string['email'] = 'Email';
$string['selectuser'] = 'Sélectionner';
$string['selecteduser'] = 'Sélectionné';
$string['cohortsforuser'] = 'Cohortes de l\'utilisateur';
$string['addtocohort'] = 'Ajouter à une cohorte';
$string['selectcohort'] = '-- Sélectionner une cohorte --';
$string['add'] = 'Ajouter';
$string['remove'] = 'Retirer';
$string['removeconfirm'] = 'Êtes-vous sûr de vouloir retirer cet utilisateur de cette cohorte ?';
$string['useraddedtocohort'] = 'Utilisateur ajouté à la cohorte avec succès.';
$string['userremovedfromcohort'] = 'Utilisateur retiré de la cohorte avec succès.';
$string['usernomemberships'] = 'Cet utilisateur n\'appartient à aucune cohorte.';

// Colonnes du tableau des cohortes.
$string['description'] = 'Description';
$string['membercount'] = 'Membres';
$string['enrolcount'] = 'Inscriptions';
$string['searchcohortplaceholder'] = 'Rechercher une cohorte...';

// Suppression de cohorte.
$string['deletecohort'] = 'Supprimer la cohorte';
$string['deletewarning'] = 'Cette action est irréversible. La cohorte et toutes ses associations de membres seront définitivement supprimées.';
$string['deletetypename'] = 'Pour confirmer, saisissez le nom exact de la cohorte ci-dessous :';
$string['deletetypeplaceholder'] = 'Saisissez le nom de la cohorte ici...';
$string['cancel'] = 'Annuler';
$string['confirmdelete'] = 'Supprimer définitivement';
$string['cohortdeleted'] = 'Cohorte supprimée avec succès.';
$string['deletenamenotmatch'] = 'Le nom saisi ne correspond pas au nom de la cohorte. Suppression annulée.';

// Erreurs.
$string['cohortnotfound'] = 'Cohorte introuvable.';
$string['emptycohortname'] = 'Le nom de la cohorte ne peut pas être vide.';
$string['emptygroupname'] = 'Le nom du groupe ne peut pas être vide.';
$string['invalidaction'] = 'Action invalide.';

// Événements.
$string['eventcohortrenamed'] = 'Cohorte renommée';
$string['eventgrouprenamed'] = 'Groupe renommé';
$string['eventgroupsbatchrenamed'] = 'Groupes renommés en lot';

// Confidentialité.
$string['privacy:metadata'] = 'Le plugin Gestionnaire de cohortes ne stocke aucune donnée personnelle.';
