file = open("insertdata.sql","w")

default_db = 'drupal8'
scilab_db = 'scilab'
esim_db = 'esim'
dwsim_db = 'dwsim_2015'
cfd_db = 'cfd_2015'
openmodelica_db = 'openmodelica'
r_db = 'r_2017'
or_db = 'or_fossee'

file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+scilab_db+".lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+esim_db+".lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+dwsim_db+".lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+cfd_db+".lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+openmodelica_db+".lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+r_db+".lab_migration_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+scilab_db+".textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+esim_db+".textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+cfd_db+".textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+dwsim_db+".textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+openmodelica_db+".textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+or_db+".textbook_companion_proposal l WHERE l.university NOT IN (	SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+r_db+".textbook_companion_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.venue,l.city,l.state,l.country FROM "+default_db+".workshop l WHERE l.venue NOT IN (	SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.venue;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+esim_db+".esim_circuit_simulation_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")
file.write("\n")
file.write("INSERT INTO "+default_db+".clg_names SELECT l.university,l.city,l.state,l.country FROM "+dwsim_db+".dwsim_flowsheet_proposal l WHERE l.university NOT IN (SELECT c.name FROM "+default_db+".clg_names c) GROUP BY l.university;")