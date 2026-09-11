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

$string['actions'] = 'Actions';
$string['add'] = 'Ajouter';
$string['addtocohort'] = 'Ajouter à une cohorte';
$string['backtocohortlist'] = 'Retour à la liste des cohortes';
$string['batchrename'] = 'Renommer tous les groupes';
$string['batchrenameconfirm'] = 'Êtes-vous sûr de vouloir renommer tous les groupes de cette cohorte ? Cette action est irréversible.';
$string['batchrenamedesc'] = 'Renommer tous les groupes associés aux inscriptions de cette cohorte avec le même nom. Cela affecte tous les cours où cette cohorte est inscrite.';
$string['batchrenamegroups'] = 'Renommage des groupes en lot';
$string['cancel'] = 'Annuler';
$string['cannotmanagecohort'] = 'Cette cohorte est gérée par un autre composant (\'{$a}\') et ne peut pas être modifiée ici.';
$string['cohort_manager:manage'] = 'Gérer les déploiements de cohortes';
$string['cohort_manager:removeenrolment'] = 'Supprimer une cohorte d\'un cours';
$string['cohortdeleted'] = 'Cohorte supprimée avec succès.';
$string['cohortidnumber'] = 'Identifiant';
$string['cohortname'] = 'Nom de la cohorte';
$string['cohortnamesection'] = 'Nom de la cohorte';
$string['cohortnotfound'] = 'Cohorte introuvable.';
$string['cohortrenamed'] = 'Cohorte renommée avec succès.';
$string['cohortsforuser'] = 'Cohortes de l\'utilisateur';
$string['componentmanagednotice'] = 'Cette cohorte est gérée par un autre composant : elle ne peut être ni renommée ni supprimée ici.';
$string['componentmanagedshort'] = 'Gérée par un autre composant';
$string['confirmdelete'] = 'Supprimer définitivement';
$string['confirmremoveenrolment'] = 'Supprimer de ce cours';
$string['coursename'] = 'Nom du cours';
$string['courseshortname'] = 'Nom abrégé';
$string['creategroup'] = 'Créer le groupe';
$string['deletecohort'] = 'Supprimer la cohorte';
$string['deletenamenotmatch'] = 'Le nom saisi ne correspond pas au nom de la cohorte. Suppression annulée.';
$string['deletetypename'] = 'Pour confirmer, saisissez le nom exact de la cohorte ci-dessous :';
$string['deletetypeplaceholder'] = 'Saisissez le nom de la cohorte ici...';
$string['deletewarning'] = 'Cette action est irréversible. La cohorte et toutes ses associations de membres seront définitivement supprimées.';
$string['description'] = 'Description';
$string['email'] = 'Email';
$string['emptycohortname'] = 'Le nom de la cohorte ne peut pas être vide.';
$string['emptygroupname'] = 'Le nom du groupe ne peut pas être vide.';
$string['enrolcount'] = 'Inscriptions';
$string['enrolledcourses'] = 'Cours inscrits';
$string['enrolmentdeleted'] = 'La méthode d\'inscription par cohorte a été supprimée du cours.';
$string['enrolmentdeletedgroupshared'] = 'La méthode d\'inscription par cohorte a été supprimée du cours. Le groupe associé a été conservé : une autre méthode d\'inscription synchronisée de ce cours l\'alimente également.';
$string['enrolmentdeletedwithgroup'] = 'La méthode d\'inscription par cohorte et le groupe associé ont été supprimés du cours.';
$string['enrolpluginmissing'] = 'Le plugin d\'inscription par cohorte n\'est pas installé sur ce site.';
$string['eventcohortrenamed'] = 'Cohorte renommée';
$string['eventenrolmentdeleted'] = 'Inscription d\'une cohorte supprimée d\'un cours';
$string['eventgrouprenamed'] = 'Groupe renommé';
$string['eventgroupsbatchrenamed'] = 'Groupes renommés en lot';
$string['fullname'] = 'Nom complet';
$string['groupalreadyexists'] = 'Un groupe est déjà associé à cette méthode d\'inscription.';
$string['groupcreated'] = 'Groupe créé et associé à la méthode d\'inscription avec succès.';
$string['groupname'] = 'Nom du groupe';
$string['grouprenamed'] = 'Groupe renommé avec succès.';
$string['groupsbatchrenamed'] = 'Tous les groupes ont été renommés avec succès.';
$string['invalidaction'] = 'Action invalide.';
$string['keepgroup'] = 'Ne pas supprimer le groupe associé';
$string['keepgroupdesc'] = 'Laissez décoché pour supprimer également le groupe. Dans les deux cas, le groupe perd les membres qu\'il tenait de cette cohorte, car Moodle retire les adhésions créées par la méthode d\'inscription.';
$string['membercount'] = 'Membres';
$string['newgroupname'] = 'Nouveau nom du groupe';
$string['nocohortsfound'] = 'Aucune cohorte trouvée.';
$string['noenrolments'] = 'Cette cohorte n\'est inscrite dans aucun cours.';
$string['nogroup'] = 'Aucun groupe';
$string['pluginname'] = 'Gestionnaire de cohortes';
$string['privacy:metadata'] = 'Le plugin Gestionnaire de cohortes ne stocke aucune donnée personnelle.';
$string['remove'] = 'Retirer';
$string['removeconfirm'] = 'Êtes-vous sûr de vouloir retirer cet utilisateur de cette cohorte ?';
$string['removeenrolment'] = 'Supprimer la cohorte de ce cours';
$string['removeenrolmentconsequence1'] = 'La méthode d\'inscription par cohorte est supprimée du cours : la cohorte ne l\'alimente plus.';
$string['removeenrolmentconsequence2'] = 'Tous les utilisateurs inscrits par cette méthode sont désinscrits du cours et perdent les rôles qu\'elle leur donnait.';
$string['removeenrolmentconsequence3'] = 'Pour ceux dont c\'était la seule inscription au cours, Moodle supprime en plus ce qu\'il supprime à toute désinscription : leurs notes dans ce cours, leurs appartenances aux groupes et leur dernier accès.';
$string['removeenrolmentconsequence4'] = 'Recréer ensuite la méthode d\'inscription réinscrit ces utilisateurs, mais ne restaure pas les données supprimées — les anciennes notes ne reviennent que si le site est configuré pour les récupérer à la réinscription.';
$string['removeenrolmentcourse'] = 'Cours concerné :';
$string['removeenrolmentgroup'] = 'Groupe associé à cette inscription :';
$string['removeenrolmentshort'] = 'S';
$string['removeenrolmentusers'] = 'Utilisateurs inscrits au cours par cette méthode :';
$string['removeenrolmentwarning'] = 'Cette action est irréversible et touche des données réelles des utilisateurs.';
$string['rename'] = 'Renommer';
$string['renamecohort'] = 'Renommer la cohorte';
$string['restrictcohortplaceholder'] = 'ex. une année de promotion...';
$string['restrictcohortsearch'] = 'Restreindre à';
$string['search'] = 'Rechercher';
$string['searchcohortplaceholder'] = 'Rechercher une cohorte...';
$string['searchplaceholder'] = 'Rechercher des cohortes par nom, identifiant ou description...';
$string['searchuser'] = 'Rechercher un utilisateur';
$string['searchuserplaceholder'] = 'Rechercher par nom, email ou identifiant...';
$string['selectcohort'] = '-- Sélectionner une cohorte --';
$string['selecteduser'] = 'Sélectionné';
$string['selectuser'] = 'Sélectionner';
$string['useraddedtocohort'] = 'Utilisateur ajouté à la cohorte avec succès.';
$string['usercohorts'] = 'Cohortes d\'un utilisateur';
$string['username'] = 'Identifiant';
$string['usernomemberships'] = 'Cet utilisateur n\'appartient à aucune cohorte.';
$string['userremovedfromcohort'] = 'Utilisateur retiré de la cohorte avec succès.';
$string['viewdetails'] = 'Voir les détails';
