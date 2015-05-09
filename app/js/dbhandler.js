function DBHandler() {
	this.define = {};
}

DBHandler.prototype = {
	setUpDatabase: function(dbms) {
		switch(dbms) {
			case 'mysql':
				this.define.dbms = 'mysql';
				this.define.serverUrl = 'localhost/cmsc191_exer6/mysql/index.php';
				this.define.user = "root";
				this.define.pword = "";
				break;
			case 'mongodb':
				this.define.dbms = 'mongodb';
				this.define.serverUrl = 'localhost/cmsc191_exer6/mongodb/index.php';
				break;
			case 'couchdb':
				this.define.dbms = 'couchdb';
				this.define.serverUrl = 'localhost/cmsc191_exer6/couchdb/index.php';
				break;
		}
	},
	getData: function() {
		switch(this.define.dbms) {
			case 'mysql':
				$.ajax({
					url: this.define.serverUrl,
					type: 'POST',
					data: {
						func: 'getData'
					},
					success: function(data) {
						console.log(data);
					}
 				});
				break;
			case 'mongodb':
				break;
			case 'couchdb':
				break;
		}	
	},
	updateData: function(id, data) {
		switch(this.define.dbms) {
			case 'mysql':
				break;
			case 'mongodb':
				break;
			case 'couchdb':
				break;
		}		
	},
	deleteData: function(id) {
		switch(this.define.dbms) {
			case 'mysql':
				break;
			case 'mongodb':
				break;
			case 'couchdb':
				break;
		}	
	},
	addData: function(data, callback) {
		switch(this.define.dbms) {
			case 'mysql':
				break;
			case 'mongodb':
				break;
			case 'couchdb':
				break;
		}	
	}
}