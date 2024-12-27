-- Active: 1734966686789@@127.0.0.1@3306@joueurs
use joueurs;
    CREATE TABLE joueurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    img VARCHAR(255),
    position ENUM(
        'GK',
        'RB',
        'CB1',
        'CB2',
        'LB',
        'MR',
        'CM',
        'ML',
        'RW',
        'SA',
        'LW'
    ) NOT NULL,
    rating INT(11)
    
   
);
