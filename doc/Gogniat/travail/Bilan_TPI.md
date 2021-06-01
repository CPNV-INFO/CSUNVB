# Rapport de Projet TPI - Michael Gogniat : CSUNVB


## Planification initiale

Le projet se déroulera de manière agile en 4 sprint

### Sprint 1 : Multi-équipe

Date : 03/05/2021 - 10/05/2021

Review : 10/05/2021 09:00, salle selon disponibilité à convenir avec M. Carrel

Objectif(s) :

Il est possible d'ajouter/supprimer une équipe (composée d'un responsable, d'un équipier et d'une nova) sur un rapport de garde afin d'un avoir plusieurs pour le même créneau.

### Sprint 2 : Planning des secouristes (-> sprint 3)

Date : 10/05/2021 - 18/05/2021

Review : 18/05/2021 15:30, salle selon disponibilité à convenir avec M. Carrel

Objectif(s) :

Importation du planning des secouriste depuis un fichier CSV. 
Le Planning est visible par les administrateurs depuis la page Administration > secouriste

### Sprint 3 : Gestion des secouristes sur les rapports de garde (-> sprint 4)

Date : 19/05/2021 - 25/05/2021

Review : 25/05/2021 15:30, salle selon disponibilité à convenir avec M. Carrel

Objectif(s) :

Seulement les secouristes présents sur la base pour le jour en question sont proposé lors du choix d'équipes sur un rapport de garde.
Les secouristes ne faisant pas partie d'une équipe ne peuvent plus remplir un rapport de garde.
Seul les secouristes mentionnés sur le rapport si celui-ci est récent (3 jour) et les administrateurs peuvent corriger un rapport.

### Sprint 4 : Gestion de l'utilisation des novas (-> sprint 2)

Date : 26/05/2021 - 02/06/2021

Review : 01/06/2021 15:30, salle selon disponibilité à convenir avec M. Carrel 

Objectif(s) :

La page administration > novas permet de voir l'utilisation des novas par les gardes
Un administrateur peut réserver une nova pour indiquer qu'elle ne sera pas disponible




## Multi-équipe(garde)


Certaines bases possèdent plusieurs équipes de secouriste pour le jour ou la nuit, il est donc important de pouvoir les inscrire sur le rapport.

Même si 2 équipes sont présentes pour assurer la garde, un seul rapport sera gérer, car c'est actuellement leur méthode de travail sur papier.

Un bouton + de la même couleur que le créneau (bleu/noir) devra présent à côté de celui ci pour ajouter une équipe

Un boutons supprimer ne sera présent que si il y a 2 équipes ou plus car il n'est pas possible de ne pas en avoir pour un créneau.

Le nombre d'équipes pour chaque créneaux doit être renseigné dans le modèle afin de pouvoir créer de nouveaux rapports identiques

La manière de renseigner les informations pour les équipes supplémentaires resteront identiques à la première (listes déroulantes)

#### Point importants à effectuer :

Modification de la base de donnée, ajout d'une table équipes ainsi que les attributs nombres d'équipes aux modèles selon le MCD suivant :

![mcd_team](images/mcdTEeam.PNG)

Pour activer un rapport il faut vérifier que toutes les informations de toutes les équipes doivent être enregistrées

![ouverture_garde](images/activateGarde.PNG)

Adapter le code php des page utilisant les informations des équipes :
- dashboard
- liste de rapport de garde
- détail d'un rapport

Pouvoir Ajouter/Supprimer une équipe et faire attention à ce que le header du rapport s'affiche correctement sur tablette même avec plusieurs équipes par créneau

![ajouter_équipe](images/addTeam.PNG)

### Conception et Fonctionnement


Aller voir les sections "" de de la documentation technique (pas encore documenté)

## Calendrier de nova (ambulance)

Le but du calendrier est de facilité aux utilisateurs le suivit de novas et de connaitre leurs futures utilisations.

Pour l'affichage de ce calendrier, un format classique par mois à été choisis pour une bonne vision de l'utilisation de la nova.

La structure du calendrier se fait grâce à un helper, elle pourra donc être réutilisée pour le planning des secouristes si besoin

Les jours du mois seront en bleu clair (couleur principale du site), les jours du mois précédant et du mois suivant seront en gris

Les informations importantes des gardes utilisant les novas sont affichées, à savoir :
- la base sur laquelle sera utilisée la nova
- Par qui elle sera utilisée
- Quand elle sera utilisée (créneau de jour ou de nuit)


Maquette (première version)

![calNova](images/calNova.PNG)

Après réflexion lors du développement, les modifications suivantes ont été effectuées :
- Le jour actuel est affiché en jaune
- Utilisation d'une icone pour l'indication Jour/Nuit, plus visible par l'utilisateur

![newCalNova](images/newCalNova.PNG)

Pour la sélection du mois, la première idée était d'ajouter un input de type "mois"

![inputMonth](images/inputMonth.PNG)

Mais finalement après discutions avec M. Carrel, cette idée ne serait pas compatible avec certains navigateurs, l'idée retenue est donc de simples boutons flèches directionnelles pour afficher le mois précédant/suivant

![selectMonth](images/selectMonth.PNG)

Cette solution est simple à mettre en place et suffisante car les utilisateurs devraient se concentrer seulement sur "plusieurs jours ou semaines en avances" (Cahier de charges)

### Risque

Le formulaire de modification du nom de la nova déjà existant peut passer un champs qui sélectionne la nova dont on veut voir le calendrier si le secouriste n'est pas attentif.

![renameNova1](images/renameNova1.PNG)

Cette option ne sera que très peut utilisée car elle implique de nombreux changements (numéros inscrits sur les novas, etc.), elle n'a donc pas besoin d'être affichée sur toute les pages de nova

Il serait intéressant de supprimer ce formulaire et d'ajouter un icone "crayon" ouvrant un formulaire dans un popup afin de modifier le numéro d'une nova.

## Indisponibilité de nova

La calendrier des novas a pour but de planifier l'utilisation de novas, et de voir d'éventuels problèmes (une même nova utilisée par 2 équipes au même moment par exemple),
elle sont en général toujours disponible mais faut pouvoir indiquer leur indisponibilités (comme un rendez-vous au garage)

Deux gardes se déroulent par créneaux jour/nuit, il faut donc savoir si la nova sera indisponible durant la nuit, le jour ou toute la journée

La base de donnée doit être modifiée afin d'y ajouter la table indisponibilité, la base de donnée est prévue pour pouvoir avoir plusieurs entrée par jour et par créneaux mais actuellement, il est possible d'avoir d'en inscrire une seule dans le calendrier

![mcdNova](images/mcdNova.PNG)

Après analyse, discussion avec M. Carrel et quelques test, l'idée retenue pour cette fonctionnalité est la suivante :

Au survol de chaque jour du calendrier, des boutons soleil/lune (pour les créneaux jour/nuit) deviennent visible afin d'indiquer que la nova sera indisponible

![addIndispo](images/addIndispo.PNG)

Avec ensuite un formulaire permettant d'indiquer le créneau et une éventuelle remarque, le créneaux est sélectionné automatiquement en fonction de l'icône sur laquelle on a cliqué précédemment

![formIndispo](images/formIndispo.PNG)


L'icone devient rouge et aux survol il est possible de savoir pour quel raison la nova est indisponible et qui l'a indiqué

![indispo](images/indispo.PNG)

En cliquant à nouveau sur cette icône, il doit être possible de la modifier ou de annuler des données enregistrée.

## Importation du plan de travail

Le CSU ayant déjà une base de donnée avec la planning des secouriste, celui-ci sera importer grâce à un fichier CSV, dans le but de pouvoir connaître les horaires de travails de secouriste et de pouvoir ainsi planifier plus facilement les équipes sur le rapport de garde.

#### Fichier CSV

![CSVPlanning](images/CSVPlanning.PNG)

Ce fichier comprend pour chaque horaire de travail, le nom + prénom du secouriste ainsi que son matricule

Le nom et le prénom peuvent être légèrement différents ("ë" à la place de "e"), il faut donc vérifier si un utilisateur avec un nom/prénom très proche existe dans la base de donnée (cette recherche ce fait grâce à la fonction similar_text(), et demandant un correspondance à 90%). Si l'utilisateur existe, son matricule est ajouter à là base de donnée, celui-ci est unique et restera identique, rendant les prochaines recherche plus rapide

La date, pouvant être directement traitée

Le nom de service, inutile dans notre cas car il est toujours identique ("CSU")

La fonction n'est pas traitée dans le cadre du TPI selon la demande de M. Carrel

Le code PA et la désignation sont liés, ils seront tous deux enregistré dans une nouvelle table horaires, la désignation étant une string, il faut extraire les données importante à savoir :
- un nom pour l'horaire
- la base pour les horaires classiques lorsqu'elle est renseignée
- jour/nuit pour les horaires classiques lorsqu'il est renseigné

![indispo](images/mcdPlanning.PNG)

### Risque

Les noms de secouriste, des horaires ou des bases ne sont pas forcément identique entre la base de donnée du site et les donnée du fichier CSV, si cette différence est trop grande il est possible qu'elle ne soit pas reconnue ou associée à une mauvaise donnée.
Actuellement certains tests ont été effectués pour savoir si le lien entre "la vallée" et "la vallée de joux" se fait bien et qu'il n'y pas de confusion entre par exemple sainte-croix et saint-loup

## Visualisation du plan de travail

Le planning, d'un secouriste est accessible depuis la section administration en cliquant sur l'icône calendrier visible au survol d'un secouriste

![userCalendarBtn](images/userCalendarBtn.PNG)

Selon la demande dans le cahier de charge, elle est disponible seulement pour les administrateurs du site,
Mais il serait intéressant de discuter de la possibilité que cette page soit accessible par tout le monde.


Affichage du planning du secouriste dans un calendrier identique aux novas

![emptyCalendar](images/emptyCalendar.PNG)

Le nom de l'horaire est écourté ( Horaire 6 => 6 ) et le jour/nuit sont indiqué par une icône

![userCalendarInfo](images/userCalendarInfo.PNG)

Les codes de désignation utilisés au CSU (comme ci-dessous) ne sont pas utilisé, cela pourrait être mis en place, mais le temps de faire la demande pour avoir les correspondances et de tout mettre en place prendrait trop de temps pour le TPI

![polypoints](images/polypoints.png)

### Sélectionner un secouriste actif

Grâce au planning importer, il est possible de différencier les secouristes actifs sur la base pour le jour en question, la sélection sera plus facile lorsqu'il y aura presque 100 secouriste dans la liste

Les secouriste actifs sont affiché en premier et ils sont séparé par une ligne "-----"

Les autres secouriste sont toutefois aussi sélectionnable si jamais un changement de dernière minute se produit et que le planning n'est pas modifié.

![selectUser](images/selectUser.png)

## Droits de modification (garde)

### Analyse

Les secouristes qui ne sont pas présents sur un rapport de garde ne devraient pas avoir le droit de le remplir

Il faut donc limiter les droits à : 

- Tous les secouristes des équipes mentionnées sur le rapport
- Les administrateurs


Pour la correction d'un rapport, il faut aussi que l'action soit possible que par les secouristes présents sur le rapport ou par un administrateur

Si le rapport date de plus de 3 jours, un simple secouriste n'aura plus les droits de le corriger (souhait du CSU)

## Objectif atteints/Non-atteints

Tous les objectifs du cahier des charges ont été atteint, toutefois, après avoir pris rendez-vous avec le CSU et effectué des démonstrations, certains points devront être modifiés pour une meilleure utilisation (voir PV des rendez-vous).

Les modifications, ne faisant pas partie du cahier des charges n’ont pas été effectuée afin de ne pas ajouter trop de contenu au TPI, elles se feront plus tard, hors du cadre du CPNV.

## Analyse de risques

Si le serveur prend du temps à répondre, il est possible de cliquer plusieurs fois sur le même boutons ce qui exécute l'action plusieurs fois, il pourrait être intéressant à therme de désactivé le boutons lorsqu'il est cliqué

Comme la page n'est pas en permanence rechargée, si un secouriste charge la page et qu'un deuxième effectue des actions entre-deux, le premier ne verra pas les modifications.
Une solution serait d'ajouter le champ date de dernière modification sur les rapports ainsi qu'une fonction javascript (ajax), qui questionnerait le serveur afin de savoir si la page est à jour.
Le problème reste actuellement minime car chaque base possédera qu'une tablette permettant de remplir son rapport.

Une seule tablette sera présente par base pour remplir les rapports, il y aura donc un seul utilisateur connecté, pourtant plusieurs d'entre eux travailleront en même temps, il se peut donc que certaines données soient validées par un autre secouriste que celui qu'y s'est connecté au début de la garde
Le problème est de type humain et rien qui serait simple à mettre en place pour résoudre ce souci.



## Document Fournis

Ce fichier comprend les points importants par rapport au TPI (réflexion, déroulement, etc.) mais pas les points techniques importants au projet.

Tous les autres documents peuvent être retrouvés sur le [GitHub](https://github.com/CPNV-INFO/CSUNVB/tree/MGT/Doc) public, sur la branche MGT, associée à mon TPI, dans le dossier Doc/Gogniat (Attention il peut y avoir un problème avec 2 dossier doc,"doc" "et "Doc" suite au travail précédant effectué avec des collègues)

La documentation technique qui explique le fonctionnement du site pour de potentiels futurs développeurs

La documentation de déploiement

Le journal de bord, contenant les évènements importants du projet

Le Journal de Travail, exporter depuis Icescrum et tenu à jour deux fois par semaine (mardi et jeudi)

Le Journal de Test, exporter depuis Icescrum, il liste les différents tests de validation, il est tenu à jour à chaque fin de sprint

Les PV des 2 rendez-vous avec le CSU

La documentation de remise au client


## Conclusion

Dans l'ensemble le projet s'est bien déroulé, et il n'y pas eu trop de perte de temps à cause de bug, les fonctionnalités, même si le cahier des charges ne correspondait pas parfaitement aux attentes du CSU, ceux-ci sont satisfaits du résultat.
Suite au bon déroulement je continuerai donc de travailler un peu sur le projet hors du cadre du CPNV.

## Sources / Aides

Xavier Carrel, chef de projet et conseiller

Besjan Sejrani (collègue), avis sur le design du site

[Behance](https://www.behance.net/) : Recherche d'idée graphique

[W3schools](https://www.w3schools.com/css/) : Aide et rappel CSS/PHP

[PHP.net](https://www.php.net/) : Manuel PHP

