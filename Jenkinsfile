pipeline {
  agent any
  stages {
    stage('dummy stage') {
      steps {
        sh 'echo 11;'
        build(job: 'job1', propagate: true, quietPeriod: 1, wait: true)
      }
    }

  }
}