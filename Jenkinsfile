pipeline {
    agent any
    
    /*environment {
        BRANCH_NAME="develop"
        CONTAINER_NAME="devops_container"
    }*/

    stages {
        stage('Build') {
            steps {
                //Se realiza la instalación de las dependencias
                sh 'composer update'
                sh 'composer dump-autoload'
                sh 'composer install'
                //Copiamos el contenido del archivo .env.testing a .env
                sh 'cp .env.test .env'
                sh 'php artisan key:generate'
            }
        }

        stage('Test') {
            steps {
                //Corremos migraciones y llenamos la base de datos
                sh 'php artisan mysql:createdb'
                sh 'php artisan migrate:fresh'
                sh 'php artisan db:seed'
                sh './vendor/bin/phpunit'
            }
        }

        stage('Invoke Deploy Pipeline'){
            steps {
                //Llamamos al siguiente Pipeline
                script{
                    build job: 'DevopsDeployJob'
                }
            }
        }

        /*stage('Deploy') {
            steps {
                //Cambiamos el host de la base de datos al del contenedor en docker
                sh "sed -i -e 's/DB_HOST=localhost/DB_HOST=172.17.0.2/g' .env"
                //Paramos el contenedor y lo eliminamos
                sh 'docker stop ${CONTAINER_NAME} || true && docker rm ${CONTAINER_NAME} || true'
                //Generamos la nueva imagen
                sh 'docker build -t devops-${BRANCH_NAME}:1.0.0-${BUILD_NUMBER} .'
                //Creamos el contenedor con la imagen y la iniciamos
                sh 'docker container create --name=${CONTAINER_NAME} -p 8000:8000 devops-${BRANCH_NAME}:1.0.0-${BUILD_NUMBER}'
                sh 'docker container start ${CONTAINER_NAME}'
            }
        }*/
    }
}
