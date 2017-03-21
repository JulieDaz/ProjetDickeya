#########################################################################
PROJET DICKEYA - README

Auteurs :
DAZENIERE Julie
KIM Yujin
MORANGES Maëlle
#########################################################################


#########################################################################
INSTRUCTIONS D'INSTALLATION
#########################################################################

#### Installer XAMPP ####
Télécharger le fichier correspondant à l’OS utilisé :
Lien pour Windows : https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.1.1/xampp-win32-7.1.1-0-VC14.zip/download 

Lien pour Linux : https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/7.1.1/xampp-linux-x64-7.1.1-0-installer.run/download 

Lien pour MacOS : https://sourceforge.net/projects/xampp/files/XAMPP%20Mac%20OS%20X/7.1.1/xampp-osx-7.1.1-0-installer.dmg/download 

Décompresser le fichier .zip dans le répertoire de votre choix afin d’y créer le répertoire xampp.

Décompresser également l’archive ProjetDickeya.zip qui contient tous les fichiers dont vous aurez besoin par la suite. 
Elle se compose :
	- Des données permettant l'importation de la base de données (répertoire data)
	- Des scripts de création de la base de données (répertoire script)
	- Le .zip de la base de données déjà implémentée
	- Le fichier .sql permettant la création des tables de la base de données (répertoire SQL)
	- Les fichiers concernant l'interface Web (répertoire interface)

#### Importer la base de données ####

# Création de la base de données #
Deux possibilités : 
•	Importation manuelle par le script SQL : 
1.	Lancer xampp
2.	Ouvrir un navigateur web et taper http://localhost/phpmyadmin/ dans la barre d’url.
3.	Cliquer sur “nouvelle base de données” et créer une nouvelle base de données que vous appellerez “Dickeya”.
4.	Copier le contenu du fichier creation_BD.sql dans la rubrique SQL de la base de données Dickeya.

•	Importation par le script python
1.	Suivre les 3 premières étapes de l’importation manuelle.
2.	Installer python3.4
3.	Télécharger le package python nommé mysql.connector :
	- Linux : sudo apt-get install -y python3-mysql.connector
	- Windows : https://dev.mysql.com/downloads/file/?id=467791 
	- MacOS : https://dev.mysql.com/downloads/file/?id=467834 
4.	Pour Windows : exécuter le script creation_bd.py (répertoire scripts)

# Remplissage de la base de données #

Deux possibilités :
•	Importation de la base de données manuellement : 
Dans http://localhost/phpmyadmin/ cliquer sur Dickeya, puis sur l’onglet “Import”. A l’aide de l’explorateur de fichier, ouvrir le fichier BD_Dickeya.sql.zip

•	Importation de la base de données par un script :

1.	Télécharger le package python nommé Biopython : 
	- Linux : 
	•	pip3 install biopython
	•	python3 setup.py build
	•	python3 setup.py test
	•	sudo python3 setup.py install
	- Windows : http://biopython.org/DIST/biopython-1.68.win32-py3.4.msi
	- MacOS : 
	•	sudo easy_install pip3
	•	pip3 install biopython
	•	python3 setup.py build
	•	python3 setup.py test
	•	sudo python3 setup.py install

2.	Suivre ensuite les étapes selon votre système d’exploitation (répertoire scripts) :
	- Linux : exécuter la commande sh insertion.sh 
	- Windows : exécuter les scripts un par un dans l’ordre suivant : script_parsing_fasta.py, script_blastout.py, script_correspondance.py, script_family.py 
	- MacOS : exécuter la commande bash ./insertion.sh 

#########################################################################
MISE EN PLACE DE L’INTERFACE
#########################################################################

Dans le dossier htdocs situé dans le dossier xampp, créer un répertoire Dickeya. Copier-coller l'intégralité du contenu du répertoire interface (situé dans le répertoire ProjetDickeya préalablement décompressé) dans le répertoire Dickeya que vous venez de créer. 

#########################################################################
EXÉCUTION DU PROGRAMME
#########################################################################

Tout d’abord il faut exécuter xampp :
Linux : sudo ./opt/lampp/xampp start
Windows : lancer xampp.control. Ensuite il faut cliquer sur « start » pour Apache et MySQL.
Mac : SUDO ./Applications/XAMPP/xamppfiles/xampp start

Lancer ensuite un navigateur Web (e.g., Firefox, Chrome) et taper l’URL : http://localhost/Dickeya

Vous pouvez maintenant utiliser notre interface ! Pour plus d’informations, veuillez consulter le guide d’utilisateur fourni. 



