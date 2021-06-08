# Bilan Théo Gautier

## Analyse préliminaire

### Planification initiale

| Sprint | Début | Fin | Contenu | 
| ---- | ---- | ---- | --- | --- |
| Début et planification | 03/05/2021 | 03/05/2021 | - Procédure de début de TPI et Planification |
| Sprint 1 | 04/05/2021 | 07/05/2021 | - Sortir une ampoule de la pharmacie |
| Sprint 2 | 10/05/2021 | 19/05/2021 | - Disposer des statistiques d'usage sous forme de tableau croisé dynamique<br> - Premier rendez vous avec le CSUNVB | 
| Sprint 3 | 20/05/2021 | 27/05/2021 | - Obtenir un token d'authentification<br> - Obtenir la liste des bases<br> - Obtenir la liste des rapports<br> - Second rendez vous avec le CSUNVB |
| Sprint 4 | 28/05/2021 | 03/06/2021 | - Obtenir la liste des actions<br> - Obtenir la liste des contrôles manquants<br> - Reporter une valeur de contrôle |
|  Mise au propre + livrable final | 04/06/2021 | 04/06/2021 | - Mise au propre et préparation du livrable final |

![diagram de grant](images/Planification_initiale_diagram.png)

### Analyse de risques
L'analyse de risques correspond aux risques qui peuvent porter préjudice a bon déroulement du projet

| Risque | Contre-mesure réalisable | impacte sur le projet |
| ---- | ----| ---- |
| Perte des données | Versionning sur git | Fort - Il va falloir recommencer si nous n'avons aucun backup |
| Incendie durant le temps de réalisation du projet (le projet est versionné sur git) | aucune | Moyen - Du temps sera perdu et nous pouvons perdre la partie pas encore push sur git, mais si cela a été fait régulièrement il y a relativement peu de pertes | 
| Fermeture du CPNV pour covid-19 | aucune, si ce n'est contribuer au respect des mesures | Moyen à Fort - Cela signifiera que je devrais travailler depuis chez moi et j'ai beaucoup de peine à y travailler car j'ai de la peine à rester concentré sur mon travail et suis facilement distrait. Cela signifierais donc un ralentissement relativement fort du travail. |
| Maladie | Aucune pour empecher mais avoir un envionnement de travail prêt à la maison pour essayer d'avancer un peu pour dimminuer l'impact | Faible à Moyen - Des retards sont possible sur le travail |
| Rendez-vous urgants qui doivent être pris sur le temps de réalisation du projet | Faire en sorte de les placer à des moments moins problématiques ou faire le travail qui ne pourra pas être fait à ce moment en amont ou avoir prévu du temps pour rattraper après | Faible - Pourrait entraîner des retard relativements faibles |

## Objectifs atteints / non-atteints
 Au début du TPI nous avions un total de 8 objectifs répartis en 3 catégories. Voir cahier des charges pour la liste de ses objectifs.

 Je me suis rapidement rendu compte, en analysant plus profondément chaque story afin de faire les tests sur IceScrum, que je ne pensais pas pouvoir faire tout le travail demandé dans le temps des 90 heures.

 Suite à ça, nous avons, avec le chef de projet, re-priorisé les taches en effectuant celles relatives à l'API d'abord, puis la sortie de la pharmatie et si j'y arrivais, les statistiques. Comme je le prévoyait au début du TPI, J'ai pu terminer tous les objectifs relatifs à l'API et à la sortie de pharmatie mais n'ai pas eu le temps de faire la partie statistiques. Cette dernière avait donc été déplanifiée.

## Points positifs / négatifs

Pour les points positifs durant le projet il y a la communication entre moi et le chef de projet qui étais très bonne et cela a permis d'être efficace durant le projet.

Pour ce qui est des points négatifs, au début du projet j'ai eu de mal à démarrer correctement car afin de pouvoir fournir un journal de travail, il fallait pouvoir terminer et valider les stories et tests pour pouvoir commencer à utiliser la plateforme IceScrum et mettre des temps sur les taches des stories et générer le journal de trvail. Malheureusement, le chef de projet n'était pas disponible tout de suite pour tout valider ce qui a provoqué un retard dans la livraison du jounal de travail aux experts. Je tire de cela que le mélange des besoins de suivi de TPI et du workflow agile IceScrum peut dans certains cas avoir une compatibilité qui a ses limites dans la phase du début de projet.

## Difficultés particulières

Une des grandes difficultés durant ce projet a été de faire suivre correctement le déroulement du projet aux experts qui n'avaient pas d'accès à IceScrum et je ne savais pas si je leur donnais suffisament d'informations ou pas assez et je devais du coup effectuer le travail à double.

D'un point de vue technique, j'ai eu de la peine à trouver le bon moyen de faire pour l'affichage des sorties spéciales de stupéfiants. Les besoins d'étaient pas les même que le reste du rapport. J'ai fini par avoir l'idée d'utiliser une popup pour intégrer cette fonctionnalité au rapport.

## Suites possibles pour le projet (évolutions & améliorations)

Le projet a encore de nombreux bugs et améliorations nécéssaires décrites au travers d'issues sur le repository github. Ensuite, une fois cela fini, puis ce qu'il y a un client, il peut y avoir des demandes de modifications de certaines choses ou d'ajout d'autres fonctionnaités que ne n'avions pas encore envisagées. Il y a un projet de continuer le développement de cette application a titre privé par la suite avec le CSUNVB sans l'implication du CPNV.

## Journal de bord

Ce journal est une copie du journal présent sur Icescrum. Il est ordré du plus récent au plus ancien.

| Personne et date | Entrée du journal |
| --- | --- |
| TGR 03.06.2021 | Fin de sprint 4 et début de la phase de fin de projet. |
| TGR 27.05.2021 | Examen d'ECG toute la matinée. Il y a donc une exception au plan horraire du cahier des charges, les périodes de TPI n'ont pas eu lieues. |
| TGR 25.05.2021 | J’ai eu un entretient durant 30 minutes. Je n’ai donc pas travaillé sur le projet de TPI durant ce temps là. |
| XCL 22.05.2021 | Revue du planning: le sprint 5 (statistiques) est abandonné, d’une part pour rattraper le retard concédé au sprint 3 et d’autre part en faveur d’une qualité supérieure attendue dans la présentation du rapport de stupéfiant (colonne ‘sortie’ + CSS amélioré (issue #90)) |
| XCL 22.05.2021 | Sprint 3 review: plusieurs problèmes constatés malgré une bonne partie des fonctionnalités OK. Aucune story ne peut être validée. Répétition du SR agendée à mardi 25 |
| XCL 17.05.2021 | Envoi par mail à Théo des informations nécessaires à l’envoi de SMS |
| TGR 17.05.2021 | Début du sprint 3. | 
| TGR 11.05.2021 | Fin du Sprint 2 et sprint review. Tout les objectifs du sprint ont été atteints. |
| TGR 06.05.2021 | Avec l'aval du chef de projet, j'ai clos le sprint 1 qui correspond au jour de lancement du TPI et ai démarré le sprint 2 sur lequel j'avais déjà travaillé en pratique. Il n'y avait rien à review pour le sprint 1. |
| XCL 05.05.2021 | Ajout de la spécification détaillée de l'API dans le repository (doc/CSUNVB API.pdf) |
| TGR 04.05.2021 | Après avoir fait une planification initiale et avoir pris connaissance de l'ampleur du travail à effectuer et des spécificités de chaque taches, j'ai le sentiment qu'effectuer le cahier des charges dans on entièreté sera difficile dans les 90 heures du TPI.<br><br> Pour cette raison, j'ai contacté mon chef de projet et nous avons eu une réunion rapide pour faire le point sur les questions que j'avais et le faite que je ne pense pas pouvoir finir tout le cahier des charges dans le temps imparti.<br><br> Nous avons donc décidé de revoir l'ordre dans lequel j'effectuerais les taches afin de faire le plus important d'abord. L'ordre dans lequel sera effectué les taches est donc:  l'API puis ensuite la sortie de stupéfiants de la pharmatie et pour finir les statistiques |
| TGR 03.05.2021 | Début du TPI |

## Journal de travail
Voir document fourni séparément.

## Annexes
- projet sur github
- Documentation technique
- Journal de travail
- Résumé de TPI




