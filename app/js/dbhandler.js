function DBHandler() {
	this.define = {};
}

DBHandler.prototype = {
	setUpDatabase: function(dbms) {
		switch(dbms) {
			case 'mysql':
				this.define.dbms = 'mysql';
				this.define.serverUrl = 'localhost/cmsc191_exer6/mysql/index.php';
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
	getData: function(callback) {
		$.ajax({
			url: this.define.serverUrl,
			type: 'POST',
			data: {
				func: 'getData'
			},
			success: function(data) {
				var result = JSON.parse(data);
				callback(result);
			}
		});
	},
	updateData: function(id, data) {
		data.price = Number.parseFloat(data.price);
		data.quantity = Number.parseInt(data.quantity);
		$.ajax({
			url: this.define.serverUrl,
			type: 'POST',
			data: {
				func: 'updateData',
				data: JSON.stringify(data)
			},
			success: function(data) {
				console.log(data);
			}
		});
	},
	deleteData: function(id, priceids) {	
		var deleting = {
			id: id,
			priceids: priceids
		};

		$.ajax({
			url: this.define.serverUrl,
			type: 'POST',
			data: {
				func: 'deleteData',
				data: JSON.stringify(deleting)
			},
			success: function(data) {
				console.log(data);
			}
		});
	},
	addData: function(add, callback) {
		var price = Number.parseFloat(add.price);
		var quantity = Number.parseInt(add.quantity);
		var data = {
			name: add.name,
			distributor: add.distributor,
			price: price,
			quantity: quantity,
			dateAdded: add.dateAdded,
			priceHistory: {
				price: price,
				dateUpdated: add.priceHistory[0].dateUpdated
			}
		};

		$.ajax({
			url: this.define.serverUrl,
			type: 'POST',
			data: {
				func: "addData",
				data: JSON.stringify(data)
			},
			success: function(data) {
				var result = JSON.parse(data);
				callback(result);
			}
		});
	}
}