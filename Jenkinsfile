pipeline {
    agent any
    
    environment {
        DOCKER_IMAGE = "bharat183/wordpress"
        KUBE_NAMESPACE = "wordpress-ns"
    }
    
    stages {
        stage("Checkout Code") {
            steps {
                echo ("Fetching the code from Github...")
                git url: "https://github.com/Bharat16092003/wordpress-custom.git", branch: "main"
            }
        }
        stage("Build Docker Image") {
            steps {
                echo ("Building Docker Image...")
                sh "docker build -t $DOCKER_IMAGE:${BUILD_NUMBER} ."
                sh "docker tag $DOCKER_IMAGE:${BUILD_NUMBER} $DOCKER_IMAGE:latest"
            }
        }
        stage("Push to Docker Hub") {
            steps {
                echo "Pushing image into Docker Hub..."
                withCredentials([usernamePassword(credentialsId:"dockerhub-login", usernameVariable: "USERNAME", passwordVariable: "PASSWORD" )]) {
                    sh """
                        echo "$PASSWORD" | docker login -u "$USERNAME" --password-stdin
                        docker push $DOCKER_IMAGE:${BUILD_NUMBER}
                        docker push $DOCKER_IMAGE:latest
                        docker logout
                     """
                  }
              }
          }
          stage("Deploy to kubernetes") {
              steps {
                  echo "Updating new image..."
                  sh """
                      kubectl set image deployment/wp-deployment wp-cont=$DOCKER_IMAGE:${BUILD_NUMBER} -n $KUBE_NAMESPACE
                      kubectl rollout status deployment/wp-deployment -n $KUBE_NAMESPACE
                  """
               }
          }
          stage("Post Verification") {
              steps {
                  echo "Checking running pods..."
                  sh "kubectl get pods -n $KUBE_NAMESPACE -o wide"
              }
          }
    }
}
