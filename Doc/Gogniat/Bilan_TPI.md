# Rapport de Projet TPI - Michael Gogniat : CSUNVB


## Planification initiale

Le projet se déroulera de manière agile en 4 sprint

### Sprint 1 : Multi-équipe

Date : 03/05/2021 - 10/05/2021

Review : 10/05/2021 09:00, salle selon disponibilité à convenir avec M. Carrel

Objetif(s) :

Il est possible d'ajouter/supprimer une équipe (composée d'un responsable, d'un équipier et d'une nova) sur un rapport de garde afin d'un avoir plusieurs pour le même créneau.

### Sprint 2 : Planning des secouristes

Date : 10/05/2021 - 18/05/2021

Review : 18/05/2021 15:30, salle selon disponibilité à convenir avec M. Carrel

Objetif(s) :

Importation du planning des secouriste depuis un fichier CSV. 
Le Planning est visible par les administrateurs depuis la page Administration > secouriste

### Sprint 3 : Gestion des secouristes sur les rapports de garde

Date : 19/05/2021 - 25/05/2021

Review : 25/05/2021 15:30, salle selon disponibilité à convenir avec M. Carrel

Objetif(s) :

Seulement les secouristes présents sur la base pour le jour en question sont proposé lors du choix d'équipes sur un rapport de garde.
Les secouristes ne faisant pas partie d'une équipe ne peuvent plus remplir un rapport de garde.
Seul les secouristes mentionnés sur le rapport si celui-ci est récent (3 jour) et les administrateurs peuvent corriger un rapport.

### Sprint 4 : Gestion de l'utilisation des novas

Date : 26/05/2021 - 02/06/2021

Review : 01/06/2021 15:30, salle selon disponibilité à convenir avec M. Carrel 

Objetif(s) :

La page administration > novas permet de voir l'utilisation des novas par les gardes
Un administrateur peut réserver une nova pour indiquer qu'elle ne sera pas disponible




## Multi-équipe(garde)

### Analyse

Certaines bases possèdent plusieurs équipes de soucouriste pour le jour ou la nuit, il est donc important de pouvoir les incricre sur le rapport.

Même si 2 équipes sont présentes pour assurer la garde, un seul rapport sera gérer, car c'est actuellement leur méthode de travail sur papier.

Un bouton + de la même couleur que le créneau (bleu/noir) est présent à côté de celui ci pour ajouter une équipe

Le boutons supprimer n'est présent que si il y a 2 équipes ou plus car il n'est pas possible de ne pas en avoir pour un créneau.

Le nombre d'équipes pour chaque créneaux doit être renseigné dans le modèle afin de pouvoir créer de nouveaux rapports identiques

La manière de renseignr les informations pour les équipes supplémentaires resteront identiques à la première (listes déroulantes)

Pour activer un rapport toutes les informations de toutes les équipes doivent être enregistrées

## Droits de modification (garde)

### Analyse

Les secoursites qui ne sont pas présents sur un rapport de garde ne devraient pas avoir le droits de le remplir

Il faut donc limiter les droits à : 

- Tous les secouristes des équipes mentionnées sur le rapport
- Les administrateurs


Pour la correction d'un rapport, il faut aussi que l'action soit possible que par les secouristes présents sur le rapport ou par un administrateur

Si le rapport date de plus de 3 jours, un simple secouriste n'aura plus les droits de le corriger (souhait du CSU)

### Risque

Une seule tablette sera présente par base pour remplir les rapports, il y aura donc un seul utilisateur connecté, pourtant plusieurs d'entre eux travailleront en même temps, il se peut donc que certaines données soient validées par un autre secouriste que celui qu'y s'est connecté au début de la garde




## Analyse de risques


## Objectif atteints/Non-atteints

## Document Fournis

## Conclusion

## Sources / Aides
