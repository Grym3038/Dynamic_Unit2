/*
    Title: Build Database
    Purpose: Build and configure the database of the application
*/

/* Create the database and user */

DROP DATABASE IF EXISTS spotifyClone;
DROP USER IF EXISTS spotifyClone;

CREATE DATABASE spotifyClone;
USE spotifyClone;

CREATE USER IF NOT EXISTS spotifyClone@localhost
IDENTIFIED BY 'password';

GRANT SELECT, INSERT, UPDATE, DELETE
ON spotifyClone.*
TO spotifyClone@localhost;

/* Create the tables */

CREATE TABLE artists (
    id               int           AUTO_INCREMENT,
    name             varchar(255)  NOT NULL,
    iPath            varchar(2023) NOT NULL,
    monthlyListeners int           NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT artistsUkName UNIQUE (name)
) ENGINE = INNODB;

CREATE TABLE albums (
    id       int           AUTO_INCREMENT,
    name     varchar(1023) NOT NULL,
    iPath    varchar(2023) NOT NULL,
    artistId int           NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT albumsFkArtistId FOREIGN KEY (artistId) REFERENCES artists(id)
        ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE songs (
    id      int           AUTO_INCREMENT,
    name    varchar(1023) NOT NULL,
    length  int           NOT NULL,
    albumId int           NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT songsFkAlbumId FOREIGN KEY (albumId) REFERENCES albums(id)
        ON DELETE CASCADE
) ENGINE = INNODB;

CREATE TABLE artistsSongs (
    id       int AUTO_INCREMENT,
    artistId int NOT NULL,
    songId   int NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT artistsSongsFkArtistId FOREIGN KEY (artistId)
        REFERENCES artists(id) ON DELETE CASCADE,
    CONSTRAINT artistsSongsFkSongId FOREIGN KEY (songId) REFERENCES songs(id)
        ON DELETE CASCADE,
    CONSTRAINT ukArtistSong UNIQUE (artistId, songId)
) ENGINE = INNODB;

/* Insert the sample data */

INSERT INTO artists (name, iPath, monthlyListeners)
VALUES ('Coldplay', 'images/artists/coldPlay.png', 47850643),
       ('Sabrina Carpenter', 'images/artists/sabrinaCarpenter.png', 32976052),
       ('Zach Bryan', 'images/artists/zachBryan.png', 5965245),
       ('Luke Combs', 'images/artists/lukeCombs.png', 41065710),
       ('Post Malone', 'images/artists/postMalone.png', 48176336),
       ('Kendrick Lamar', 'images/artists/kendrickLamar.png', 44523462),
       ('Teddy Swims', 'images/artists/teddySwims.png', 45574887),
       ('Eminem', 'images/artists/Eminem.png', 39851740),
       ('Travis Scott', 'images/artists/travisScott.png', 29176861),
       ('Tyler, the Creator', 'images/artists/tylerTheCreator.png',  10649493)
       ;

INSERT INTO albums (name, iPath, artistId)
VALUES ('Pre-emptive encompassing open architecture', 'images/albums/openArchitecture.png', 3),
       ('Adaptive needs-based solution', 'images/albums/basedSolution.png', 5),
       ('Adaptive mobile ability', 'images/albums/mobileAbility.png', 8),
       ('Secured zero administration budgetary management', 'images/albums/budgetaryManagement.png', 3),
       ('Adaptive 4th generation time-frame', 'images/albums/timeFrame.png',  8),
       ('Future-proofed object-oriented archive', 'images/albums/orientedArchive.png', 7),
       ('Cloned leading edge database', 'images/albums/edgeDatabase.png', 6),
       ('Programmable real-time matrix', 'images/albums/timeMatrix.png', 6),
       ('User-friendly zero administration Graphical User Interface', 'images/albums/userInterface.png',  3),
       ('Right-sized asynchronous artificial intelligence', 'images/albums/artificialIntelligence.png', 10),
       ('Diverse reciprocal groupware', 'images/albums/reciprocalGroupware.png',  6),
       ('Public-key actuating core', 'images/albums/actuatingCore.png', 5),
       ('Automated asynchronous flexibility', 'images/albums/asynchronousFlexibility.png', 6),
       ('Cross-group incremental task-force', 'images/albums/taskForce.png', 6),
       ('Compatible static help-desk', 'images/albums/helpDesk.png', 10),
       ('Reverse-engineered exuding installation', 'images/albums/exudingInstallation.png', 7),
       ('Adaptive directional hierarchy', 'images/albums/directionalHierarchy.png',  5),
       ('Right-sized neutral archive', 'images/albums/neuralNet.png',  3),
       ('Sharable dedicated local area network', 'images/albums/areaNetwork.png', 2),
       ('Upgradable logistical neural-net', 'images/albums/neuralNet.png', 4);

INSERT INTO songs (name, length, albumId)
VALUES ('Quality-focused high-level instruction set', 159, 5),
       ('Adaptive leading edge benchmark', 208, 15),
       ('Enterprise-wide web-enabled local area network', 281, 2),
       ('Open-architected executive internet solution', 583, 7),
       ('Re-contextualized national circuit', 93, 15),
       ('Robust discrete moderator', 180, 2),
       ('Right-sized asymmetric model', 327, 3),
       ('Synergistic discrete approach', 457, 3),
       ('Switchable maximized ability', 338, 3),
       ('Synergized asymmetric service-desk', 210, 4),
       ('Ameliorated motivating moratorium', 191, 1),
       ('Advanced object-oriented moratorium', 430, 19),
       ('Cloned hybrid internet solution', 171, 10),
       ('Synchronised static monitoring', 356, 19),
       ('Balanced tangible structure', 341, 10),
       ('Quality-focused 4th generation installation', 116, 20),
       ('Sharable user-facing hierarchy', 185, 11),
       ('User-centric value-added algorithm', 182, 19),
       ('Centralized human-resource framework', 230, 7),
       ('Self-enabling zero defect groupware', 316, 19),
       ('Profit-focused methodical implementation', 100, 3),
       ('Pre-emptive incremental Graphical User Interface', 473, 11),
       ('Versatile intermediate hardware', 326, 16),
       ('Persevering national methodology', 600, 9),
       ('Quality-focused stable installation', 440, 7),
       ('Operative 5th generation approach', 259, 6),
       ('Managed 3rd generation process improvement', 363, 17),
       ('Vision-oriented radical flexibility', 599, 7),
       ('Pre-emptive 3rd generation leverage', 170, 20),
       ('Programmable asynchronous toolset', 398, 4),
       ('Customizable bi-directional protocol', 522, 14),
       ('Focused full-range system engine', 196, 15),
       ('Upgradable explicit software', 108, 13),
       ('Visionary zero defect definition', 267, 19),
       ('Phased eco-centric success', 235, 3),
       ('Synergized mobile policy', 582, 7),
       ('Vision-oriented motivating throughput', 372, 17),
       ('Polarised impactful definition', 305, 6),
       ('User-friendly encompassing info-mediaries', 433, 11),
       ('Polarised zero tolerance protocol', 439, 16),
       ('Inverse grid-enabled hub', 436, 6),
       ('Re-contextualized tertiary complexity', 463, 10),
       ('Profit-focused tangible flexibility', 428, 20),
       ('Devolved composite circuit', 443, 10),
       ('Synchronised zero defect strategy', 476, 13),
       ('Ergonomic reciprocal open system', 541, 12),
       ('Optimized maximized knowledge user', 475, 18),
       ('Inverse local challenge', 215, 9),
       ('Implemented grid-enabled support', 409, 15),
       ('User-friendly asynchronous encryption', 172, 19);

INSERT INTO artistsSongs (artistId, songId)
VALUES (1, 36),
       (8, 23),
       (7, 6),
       (6, 18),
       (9, 45),
       (1, 25),
       (9, 30),
       (3, 2),
       (4, 27),
       (7, 19),
       (1, 35),
       (9, 36),
       (6, 1),
       (9, 11),
       (6, 48),
       (7, 18),
       (7, 32),
       (4, 49),
       (9, 12),
       (9, 39),
       (9, 1),
       (1, 39),
       (6, 31),
       (6, 45),
       (3, 47),
       (7, 38),
       (4, 29),
       (10, 30),
       (5, 11),
       (6, 2),
       (7, 17),
       (1, 50),
       (10, 5),
       (10, 12),
       (2, 41),
       (7, 44),
       (7, 37),
       (1, 9),
       (6, 47),
       (7, 29),
       (1, 18),
       (5, 12),
       (7, 26),
       (6, 20),
       (7, 21),
       (3, 36),
       (8, 24),
       (1, 49),
       (2, 1),
       (3, 20),
       (2, 3),
       (10, 15),
       (3, 48),
       (7, 4),
       (5, 6),
       (4, 28),
       (3, 29),
       (2, 13),
       (3, 22),
       (10, 1),
       (10, 48),
       (10, 31),
       (7, 22),
       (3, 1),
       (5, 34),
       (2, 47),
       (10, 8),
       (7, 40),
       (9, 41),
       (2, 26),
       (10, 42),
       (3, 37),
       (9, 28),
       (7, 35),
       (9, 27),
       (2, 22),
       (7, 15),
       (1, 37),
       (4, 5),
       (1, 2),
       (8, 21),
       (5, 28),
       (1, 41),
       (3, 7),
       (3, 43),
       (4, 33),
       (6, 49),
       (1, 34),
       (6, 40),
       (10, 22),
       (5, 13),
       (5, 1),
       (6, 14),
       (9, 42),
       (9, 32),
       (6, 10),
       (10, 9),
       (3, 14),
       (10, 23),
       (3, 25);
