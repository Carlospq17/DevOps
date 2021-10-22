pipeline {
    agent any

    environment {
        DB_HOST='punto_de_venta'
    }

    stages {
        stage('Install') {
            steps {
                git url:'https://github.com/Carlospq17/DevOps.git', branch:'jenkins_file'
                //Se realiza la instalación de las dependencias
                sh 'composer update'
                sh 'composer dump-autoload'
                sh 'composer install'
            }
        }
        stage('Initialize') {
            steps {
                //Renombramos el archivo de prueba .env.testing a .env y creamos la llave de la app
                sh 'cp .env.test .env'
                sh 'php artisan key:generate'
                //Corremos migraciones y llenamos la base de datos
                sh 'php artisan mysql:createdb'
                sh 'php artisan migrate:fresh'
                sh 'php artisan db:seed'
            }
        }

        stage('Test') {
            steps {
                sh './vendor/bin/phpunit --log-junit ./tests/Result/report.xml'
            }
        }
    }
}