<div ng-app="MyApp" ng-controller="AppCtrl">
	<fieldset>
		<legend>Data Product</legend>
		<div ng-repeat="crud in allData">
			<div>{{crud.item_name}}</div>
			<div>{{crud.info}}</div>
		</div>
	</fieldset>
</div>

<?php
	echo $this->registerJsFile("node_modules/app.js");
    echo $this->registerJsFile("node_modules/jquery.min.js");
    echo $this->registerJsFile("node_modules/angular/angular.js");
?>