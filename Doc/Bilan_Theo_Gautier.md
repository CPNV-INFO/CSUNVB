# Bilan Théo Gautier

## Planification initiale

| Sprint | Début | Fin | Nombre de storys |
| ---- | ---- | ---- | --- |
| 1 | 01/02/2021 | 08/02/2021 | 1 |
| 2 | 09/02/2021 | 01/03/2021 | 2 |
| 3 | 02/03/2021 | 08/03/2021 | 1 |
| 4 | 09/03/2021 | 22/03/2021 | 2 |
| 5 | 23/03/2021 | 29/03/2021 | 1 |

## Analyse de risques
L'analyse de risques correspond aux risques qui peuvent porter préjudice a bon déroulement du projet

| Risque | Contre-mesure réalisable | impacte sur le projet |
| ---- | ----| ---- |
| Perte des données | Versionning sur git | Fort - Il va falloir recommencer si nous n'avons aucun backup |
| Incendie durant le temps de réalisation du projet (le projet est versionné sur git) | aucune | Moyen - Du temps sera perdu et nous pouvons perdre la partie pas encore push sur git, mais si cela a été fait régulièrement il y a relativement peu de pertes | 
| Fermeture du CPNV pour covid-19 | aucune, si ce n'est contribuer au respect des mesures | Moyen à Fort - Cela signifiera que je devrais travailler depuis chez moi et j'ai beaucoup de peine à y travailler car j'ai de la peine à rester concentré sur mon travail et suis facilement distrait. Cela signifierais donc un ralentissement relativement fort du travail. |
| Maladie | Aucune pour empecher mais avoir un envionnement de travail prêt à la maison pour essayer d'avancer un peu pour dimminuer l'impact | Faible à Moyen - Des retards sont possible sur le travail |
| Rendez-vous urgants qui doivent être pris sur le temps de réalisation du projet | Faire en sorte de les placer à des moments moins problématiques ou faire le travail qui ne pourra pas être fait à ce moment en amont ou avoir prévu du temps pour rattraper après | Faible - Pourrait entraîner des retard relativements faibles |


## Objectifs atteints / non-atteints

| Objectif | Statut | Commentaire |
| ---- | ---- | ---- |
| Afficher un rapport cloturé | Réussi | |
| Préparer un rapport de stupéfiants | Réussi ||
| Enregistrer un rapport de stupéfiants | Réussi | |
| Signer une journée | Réussi | |
| Création d'un lot | Réussi | |
| Journal des actions | Pas réussi | N'a pas été fait car nous n'avons pas eu le temps de le placer durant le Pre-TPI |


## Points positifs / négatifs

Pour les points positifs, je pense que la communication et le workflow scrum ont bien fonctionné.

Pour le négatif, nous étions deux à travailler en parallèle et il pouvait arriver que nous avions les deux des modifications au niveau de la base de données et quand monsieur Carrel effectuait un merge des branches sur la branche master il y avait des conflits et on perdait au final des changements effectués sur la base de données. 
## Difficultés particulières
J'ai rencontré une difficulté durant le projet. Cette difficulté était que quand je définissais un tableau dans un formulaire pour soumettre toutes les données d'un rapport de stupéfiant et je mettais les noms d'index de ce tableau entre guillemets. Or, il n'y a pas besoin de mettre ses guillemets et donc du coté de PHP quand j'essayais d'accéder aux indexes du tableau je n'y arrivais pas car les guillemets étaient devenus parti intégrant du nom de l'index du tableau.  

## Suites possibles pour le projet (évolutions & améliorations)
Dans les suites possibles pour le projet, je pense qu'il est important d'améliorer l'aspect sécurité du site qui a des failles importantes. J'en ai décrit une dans [une story icescrum](https://icescrum.cpnv.ch/p/CSUNVBTGR/#/backlog/sandbox/story/2027).

Je pense aussi qu'une amélioration graphique de la page des lots de stupéfiants et de l'affichage des rapports de stupéfiants éditables où la faite que nous avons enlevé les bordures des inputs les rendent plus difficilement différenciables d'un rapport fermé.   