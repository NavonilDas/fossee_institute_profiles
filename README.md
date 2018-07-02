# fossee_institute_profiles Module
This is a Drupal 7 module used to display the profiles of institutes ie. Displays "Lab Migradtion","Textbook Companion","Workshop","Circuit Simulation","Flowsheeting Projects" etc.

## After installing the Module
Import the insertdata.sql to add data to the clg_names table

## The Script
### Installation of Script
install the pymysql library for the script
```
pip install pymysql
```
change the database name (db_name) and table name (table_name) in script.py if necessary.
the script generates del.sql in the script folder import it to the mysql.
All the same name will be deleted.