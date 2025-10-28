pipeline {
    agent any
    
    environment {
        DOCKER_IMAGE = "bharat183/mywordpress"
        DOCKER_TAG = "latest"
    }

    stages {
        stage("Checkout Code") {
            steps {
                echo "Fetching the code from GitHub..."
                git url: "https://github.com/Bharat16092003/wordpress-custom.git", branch: "main"
            }
        }

        stage("Build Docker Image") {
            steps {
                echo "Building Docker image..."
                sh "docker build -t $DOCKER_IMAGE:$DOCKER_TAG ."
            }
        }

        stage("Push to Dockerhub") {
            steps {
                echo "Pushing image to Dockerhub..."
                withCredentials([usernamePassword(credentialsId: "dockerhub-login", usernameVariable: "USERNAME", passwordVariable: "PASSWORD")]) {
                    sh '''
                        echo "$PASSWORD" | docker login -u "$USERNAME" --password-stdin
                        docker push $DOCKER_IMAGE:$DOCKER_TAG
                    '''
                }
            }
        }
        stage("Deploy with Docker Compose") {
            steps {
                echo "Deploying containers using Docker Compose"
                sh "docker-compose down"
                sh "docker-compose pull || true"
                sh "docker-compose up -d --build"
            }
        }
    }
    post {
        always {
            echo 'Pipeline completed'
        }
    }
}

