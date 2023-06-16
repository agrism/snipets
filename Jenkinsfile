pipeline {
  agent any
  environment{
    staging_server="65.21.182.7"
  }
  stages {
    stage("Deploy to remote"){
        steps {
            sh 'ssh root@${staging_server} "mkdir -p /var/www/snipets.kilograms.lv1/123'
            sh 'scp -r ${WORKSPACE}/* root@${staging_server}:/var/www/snipets.kilograms.lv1/123'
        }
    }
  }
}