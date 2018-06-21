INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM scilab.lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM esim.lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM dwsim_2015.lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM cfd_2015.lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM openmodelica.lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM r_2017.lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;    

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM scilab.textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM esim.textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM cfd_2015.textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM dwsim_2015.textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM openmodelica.textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM or_fossee.textbook_companion_proposal l WHERE l.university NOT IN (	SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM r_2017.textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.venue,l.city,l.state,l.country FROM fossee_new.workshop l WHERE l.venue NOT IN (	SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.venue;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM esim.esim_circuit_simulation_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;

INSERT INTO fossee_new.clg_names SELECT l.university,l.city,l.state,l.country FROM dwsim_2015.dwsim_flowsheet_proposal l WHERE l.university NOT IN (SELECT c.name FROM fossee_new.clg_names c) GROUP BY l.university;