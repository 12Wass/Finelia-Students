# Finelia-Students
Small project for Finelia's recruitments


## Sans Docker : 
Si vous n'utilisez pas Docker, récupérez tous les fichiers mis à disposition dans la branche master et mettez les dans votre htdocs/www.
Veillez bien à modifier le fichier PDOConnect.php pour qu'il corresponde à votre configuration!

## Docker : 
Si vous voulez utiliser Docker, j'ai mis à votre disposition un fichier docker-compose ainsi qu'un Dockerfile prêts à l'emploi (branche Docker)
Récupérez le repo sur votre ordinateur, lancez Docker et faites ```docker-compose up -d``` pour lancer le conteneur. 
Les adresses utilisées sont les suivantes : 
  - Le projet : localhost:8080
  - PHPMyAdmin : localhost:8889
  
Accédez à PHPMyAdmin, importez les fichiers SQL disponibles dans le dossier du même nom et le site sera prêt à l'emploi! 
