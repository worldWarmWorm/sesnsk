/**
 * Загрузчик
 */
var KonturLoader={
	_data: [],
	_priority: [],
	
    add: function(name, context, priority) {
        if(isNaN(priority)) 
            priority=1000000;
  
        KonturLoader._priority.push([name, priority]);
        KonturLoader._data[name]=context;
    },
 
    run: function() {
        KonturLoader._priority.sort(function(a,b) {
            if(a[1] < b[1]) return -1;
            if(a[1] > b[1]) return 1;
            return 0;
        });
        KonturLoader._priority.forEach(function(v) {
            KonturLoader._data[v[0]]();
        });
	}
};