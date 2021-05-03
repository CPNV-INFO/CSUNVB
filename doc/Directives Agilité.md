# Directives de gestion de projet

Ce document définit les attentes du chef de projet TPI en termes de gestion du projet. Elles ont été pratiquées durant le projet 'Pré-TPI'.

Il est destiné: 

- Au candidat afin qu'il n'aie aucun doute sur la méthodologie appliquée au projet.  
- En partie aux experts pour qu'ils sachent comment s'y retouver par rapport à un TPI 'standard'  

Trois outils de travail sont imposés au candidat:

1. Github pour le versionnage du code et de la documentation
1. IceScrum pour la gestion Agile du projet
3. 'Timesheet' pour le journal de travail

Le repository Github est mis à disposition des experts.
Il n'est malheureusement pas possible actuellement de leur donner accès à IceScrum - et par conséquent à Timesheet. Le candidat est responsable de "faire le pont" en publiant les informations nécessaires (signalées plus loin) au moyen de documents pdf dans le dossier 'Experts' du repo Git.

## "Home"

Tout ce qui concerne le projet est atteignable à partir du projet IceScrum. Cela implique en particulier:

- Le dashboard du projet IceScrum contient un lien sur le repo Github
- Le repo Github contient le code ET la documentation, qui se trouve dans un dossier nommé 'doc'

## Analyse préliminaire
Un document d'analyse préliminaire est écrit par le candidat. Il couvre notamment la section 1 du canevas de dossier de projet.
Plus précisément, son contenu est:

- L'introduction (qui reprend la description du Cahier des Charges)
- La liste des objectifs, définie par des User Stories placées dans la Sandbox IceScrum
- La planification initiale, qui consiste à définir les sprints dans IceScrum. Elle se présente dans ce document sous forme de table dont les colonnes sont: Sprint, Objectif, Date de début, Date de revue
- La stratégie de test
- Une analyse de risques

Le document est rédigé en markdown. Le candidat en maintient une version pdf dans le dossier 'Experts' du le repository.

## Story Workflow

Le déroulement normal de la réalisation d'une story est le suivant:

1. Le Product Owner (PO) dépose des stories dans la sandbox. Elles ne contiennent qu'un énoncé et des notes explicatives.
1. Le candidat procède à l'analyse du besoin, qu'il livre sous la forme d'une liste de tests d'acceptance de la story dans IceScrum. En cas de besoin et pour faciliter l'expression des tests, le candidat crée une ou plusieurs maquettes qu'il joint à la story IceScrum. Le temps nécessaire à cette analyse est noté au moyen d'une tâche récurrente dans IceScrum. Cette tâche porte le tag 'Analyse' 
1. L'analyse est validée par le PO, ce qu'il confirme en déplaçant la story dans le product backlog
1. Le candidat procède à l'estimation de la story. Pour cela:
    - Il définit (dans la story) une liste de tâches dont il estime la durée en minutes (reportée dans le champ 'remaining time' de la tâche)
    - Il inclut une tâche de documentation
    - Il procède à l'estimation par comparaison de la story complète
    - Le temps nécessaire à cette estimation est noté au moyen d'une tâche récurrente dans IceScrum. Cette tâche porte le tag 'Analyse'
1. Le candidat et le PO planifient la story en la déplaçant dans le sprint backlog, puis en activant le sprint lors du sprint planning
1. Le candidat reporte son temps de travail (en minutes) dans le champ 'time spent' de chaque tâche
1. Lorsque le candidat a terminé le développement, il place la story dans l'état 'In Review'
1. Durant la sprint review avec le PO, les stories dans l'état 'In Review' sont revues. Elles sont ensuite soit clôturées, soit repoussées au sprint suivant

## Issues
Quand nous identifions un bug, une refactorisation mineure, un détail cosmétique, bref, quelque chose qui doit être corrigé mais qui ne justifie pas de passer par le processus d'une story, nous créons une issue dans le repo Github.  
Quand le candidat a un "trou" à disposition (en fin de journée ou en fin de sprint), il l'occupe à la résolution d'une ou plusieurs de ces issues. Ce temps de travail est noté dans IceScrum au moyen d'une 'tâche urgente'.

## Documentation technique

Tous les éléments techniques d'un dossier de projet 'standard' sont regroupées dans un document séparé intitulé 'Documentation Technique'. Ce document est formulé/structuré à l'intention de toute personne qui reprendrait le développement du produit.

Il décrit notamment:

- Les objectifs globaux du projet et le public cible
- Le contexte technique (architecture, machines, réseau, ...)
- Les modèles (conceptuel et logique) de données 
- Les composants utilisés
- Les technologies à connaître ou maîtriser pour pouvoir continuer le développement
- Les outils nécessaires au développement
- Les 'astuces' mises en place. Par astuce on entend quelque chose qui n'est pas 'standard' (comme le serait un CRUD par exemple) et qui concerne plus d'un fichier (parce que sinon les commentaires suffisent)

Le document est rédigé en markdown. Le candidat en maintient une version pdf dans le dossier 'Experts' du repository.

## Journaux

Deux journaux distincts sont tenus à jour:

1. Le journal de bord, qui contient les événements majeurs du projet. Il est tenu dans la page 'dashboard' du projet IceScrum. Le candidat met à jour régulièrement son format pdf dans le dossier 'Experts' du repository
1. Le journal de travail, qui contient le détail du temps passé sur quelles activités. Il est généré automatiquement par l'outil 'Timesheet' sur la bas des données introduites dans IceScrum. Le candidat met à jour régulièrement son format pdf dans le dossier 'Experts' du repository.

## Bilan

En fin de projet, le candidat fournit un document de bilan de projet, qui contient/reprend des points tels que:

- Planification initiale
- Analyse de risques
- Objectifs atteints / non-atteints
- Points positifs / négatifs
- Difficultés particulières
- Suites possibles pour le projet (évolutions & améliorations)

Le document est rédigé en markdown. Le candidat en maintient une version pdf dans dossier 'Experts' du repository.
