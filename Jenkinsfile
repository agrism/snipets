pipeline {
  agent any
  environment{
    staging_server="65.21.182.7"
    BUILDVERSION=sh(script: "echo `date +%s`", returnStdout: true).trim()
  }
  stages {
    stage("Deploy to remote"){
        steps {
            sh 'ssh root@${staging_server} "mkdir -p /var/www/snipets.kilograms.lv1/${BUILDVERSION}"'
            sh 'scp -r ${WORKSPACE}/* root@${staging_server}:/var/www/snipets.kilograms.lv1/${BUILDVERSION}'
            sh '''
                ssh root@${staging_server} "rm -rf /var/www/snipets.kilograms.lv1/prod"
            '''
            sh 'ssh root@${staging_server} "ln -s /var/www/snipets.kilograms.lv1/${BUILDVERSION} /var/www/snipets.kilograms.lv1/prod"'
            echo "Current build version :: $BUILDVERSION"
        }
    }
  }
}