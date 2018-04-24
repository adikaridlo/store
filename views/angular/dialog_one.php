<md-dialog aria-label="Mango (Fruit)">
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Mango (Fruit)</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
          <md-icon md-svg-src="" aria-label="Close dialog"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content">
        <h2>Using .md-dialog-content class that sets the padding as the spec</h2>
        <p>
          The mango is a juicy stone fruit belonging to the genus Mangifera, consisting of numerous tropical fruiting trees, cultivated mostly for edible fruit. The majority of these species are found in nature as wild mangoes. They all belong to the flowering plant family Anacardiaceae. The mango is native to South and Southeast Asia, from where it has been distributed worldwide to become one of the most cultivated fruits in the tropics.
        </p>

        <img style="margin: auto; max-width: 100%;" alt="Lush mango tree" src="">

        <p>
          The highest concentration of Mangifera genus is in the western part of Malesia (Sumatra, Java and Borneo) and in Burma and India. While other Mangifera species (e.g. horse mango, M. foetida) are also grown on a more localized basis, Mangifera indica&mdash;the "common mango" or "Indian mango"&mdash;is the only mango tree commonly cultivated in many tropical and subtropical regions.
        </p>
        <p>
          It originated in Indian subcontinent (present day India and Pakistan) and Burma. It is the national fruit of India, Pakistan, and the Philippines, and the national tree of Bangladesh. In several cultures, its fruit and leaves are ritually used as floral decorations at weddings, public celebrations, and religious ceremonies.
        </p>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button href="http://en.wikipedia.org/wiki/Mango" target="_blank" md-autofocus>
        More on Wikipedia
      </md-button>
      <span flex></span>
      <md-button ng-click="answer('not useful')">
       Not Useful
      </md-button>
      <md-button ng-click="answer('useful')">
        Useful
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>