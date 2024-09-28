@echo off

echo Démarrage du serveur Symfony...
start /B symfony server:start

echo Lancement du consommateur d'emails asynchrone...
start /B symfony console messenger:consume async

echo Exécution des tests PHPUnit...
php bin/phpunit

echo Tout est prêt!
pause

echo Arrêt du serveur Symfony...
taskkill /F /PID %SERVER_PID%
echo Serveur arrêté.