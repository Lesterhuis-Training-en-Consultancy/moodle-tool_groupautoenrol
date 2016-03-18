Version history :
- 1.1 : stable version not working (bug)
- 1.1.1 : stable version working as local plugin
- 1.1.2 : stable version working as admin tool plugin


moodle-admin_tool_groupautoenrol
===========================
Version 1.1.2 (stable version)

 
ENGLISH
-------
Plugin to randomly auto enrol students in Moodle courses groups when they are enrolled into the course (whatever the enrol methods : auto-enrol by key, cohorts sync or manual enrol)

Things to know :
- The plugin uses \core\event\user_enrolment_created (user_enrolled) Moodle event
- If a selected group is deleted, the plugin will ignore it.

In this stable version (1.1.2) :
- you can choose to enable the plugin in each course
- you can choose to auto-enrol students in all existing course or specific ones

Compatibility :
- Tested with Moodle 3.0
- Another version of the plugin exist and works with Moodle 2.5 and 2.7 (I did not test it with the others versions but should work with all 2.x).
It's a local plugin because adding link into "Course administration" menu was not possible for admin tool before Moodle 3.0
You can get it here : https://github.com/pascal-my/moodle-local_groupautoenrol/tree/STABLE


**installation**
* Copy the directory 'groupautoenrol' into the `moodledir/admin/tool` directory.
* Connect to moodle as an administrator and install the plugin.
* Go to a course, create at least one group
* Enable the plugin for the course with the new link "Course administration > Users > Auto-enrol in groups"
Note : this link appears even if the plugin is not enabled for the course


FRENCH
------
Plugin permettant l'inscription automatique aléatoire des étudiants dans les groupes des cours lors de leur inscription au cours (qu'elle se fasse par la synchronisation des cohortes, par clé d'inscription ou manuellement).

Précisions :
- Ce plugin utilise l'évènement \core\event\user_enrolment_created (user_enrolled) pour détecter l'inscription d'un utilisateur dans un cours.
- Si un groupe sélectionné pour l'inscription auto est supprimé, il sera simplement ignoré par le plugin (cela ne pose pas de blocage)
- En cas d'inscription par clé de groupe, l'utilisateur est d'abord inscrit automatiquement (selon les paramètres définis) puis il est inscrit au groupe désigné par la clé.
Selon les paramètres, il peut donc se retrouver inscrits à 1 ou 2 groupes (si le tirage aléatoire a désigné le même groupe que celui de la clé). Je n'ai pas eu de message d'erreur lorsque Moodle tente d'inscrire l'utilisateur dans le groupe de la clé même losque celui a déjà été inscrit par le plugin "inscription_auto" dans le même groupe.

Version stable (1.1.2) :
- plugin activable par cours
- l'inscription automatique se fait dans tous les groupes du cours ou uniquement dans des groupes sélectionnés.

Compatibilité
- Version testée avec Moodle 3.0
- Une version fonctionnant avec Moodle 2.5 et 2.7 existe (Non testé avec les autres versions mais il doit fonctionner avec toutes les versions de Moodle 2.x).
Il s'agit d'un plugin "local" car avant Moodle 3.0, il n'était pas possible d'ajouter un lien dans le menu "Administration du cours" pour les plugin de type "admin tool".
Il est téléchargeable ici : https://github.com/pascal-my/moodle-local_groupautoenrol/tree/STABLE


**Installation**
* Copier le dossier 'groupautoenrol' dans le répertoire `moodledir/admin/tool`.
* Se connecter en admin et installer le plugin.
* Aller dans un cours et créer au moins 1 groupe
* Activer l'inscription automatique dans le(s) groupe(s) pour le cours via le nouveau lien "Administration du cours > Utilisateurs > Groupes : Inscription auto"
Note : le nouveau lien "Administration du cours > Utilisateurs > Groupes : Inscription auto" s'affiche tout le temps, même si le plugin n'est pas activé pour le cours


credits
-------
* @copyright  2016 Pascal
* @author     Pascal M - https://github.com/pascal-my


licence
-------
This code is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
It is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this software. If not, see http://www.gnu.org/licenses/.

