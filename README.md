Je vous présente mes excuses pour l'oubli des emojis dans les titres de sections. Voici le README.md corrigé, entièrement professionnel et sans aucun emoji.

Fair Count
Description du Projet
Fair Count est une application web conçue pour rationaliser et sécuriser la gestion des comptes et des dépenses collectives au sein de groupes. Son objectif est de fournir une solution fiable pour enregistrer les transactions effectuées par chaque membre et de calculer avec précision les soldes nets dus, assurant ainsi une résolution équitable des obligations financières entre participants.

Le projet est implémenté en PHP, adhérant aux principes de la Programmation Orientée Objet (POO) et utilisant l'extension PDO pour une interaction sécurisée et robuste avec la base de données MySQL.

Caractéristiques Fonctionnelles
Authentification et Autorisation : Gestion sécurisée des sessions utilisateurs (inscription, connexion, déconnexion).

Administration des Groupes : Création, modification, et gestion des listes de membres pour chaque groupe.

Enregistrement Comptable : Saisie structurée des dépenses incluant le motif, le montant, la date, la catégorie, et l'identification de l'utilisateur ayant effectué l'avance.

Attribution des Charges : Mécanisme permettant de désigner explicitement les participants concernés par une dépense donnée, garantissant un calcul de partage précis.

Calcul des Équilibres : Mise en œuvre d'un algorithme pour déterminer le solde net de chaque membre (créancier ou débiteur).

Interface de Remboursement : Présentation claire des dettes et des créances pour faciliter les règlements interpersonnels.

Historisation : Maintenance d'un registre détaillé de toutes les dépenses par entité de groupe.

Composant,Technologie,Note
Langage,PHP,Version 8.0 ou supérieure requise.
Base de Données,MySQL / MariaDB,Moteur InnoDB requis pour l'intégrité référentielle.
Accès aux Données,PDO,Utilisation de requêtes préparées pour la sécurité.
Architecture,MVC,Structure Modèle-Vue-Contrôleur.
Frontend,HTML5 / CSS3,Interface utilisateur standard.

Guide d'Installation
Les instructions suivantes détaillent le déploiement de l'application dans un environnement de développement standard (tel que XAMPP ou WAMP).

Prérequis Logiciels
Serveur Web (Apache ou équivalent)

Interpréteur PHP (8.0+)

Système de Gestion de Base de Données MySQL/MariaDB

Étape 1 : Acquisition du Code Source
Bash

git clone https://github.com/FamilyTsuki/Projet-Fair-Count.git

Étape 2 : Initialisation de la Base de Données
Accédez à votre outil de gestion de base de données.

Créez une base de données nommée fair_count.

Importez le schéma SQL initial du projet.

Étape 3 : Configuration des Paramètres de Connexion
Veuillez mettre à jour les paramètres de connexion à la base de données (hôte, nom d'utilisateur, mot de passe) dans le fichier Manager/AbstractManager.php :

PHP

// Exemple de configuration PDO dans AbstractManager.php

protected $db;

public function __construct()
{
    $this->db = new PDO(
        'mysql:host=localhost;dbname=fair_count;charset=utf8',
        'root', // Modifier si nécessaire
        ''      // Modifier si nécessaire
    );
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
Étape 4 : Exécution de l'Application
Assurez-vous que les services Apache et MySQL sont actifs.
http://localhost/Fair-Count/
