var App = (function($, document, window){

	function App() {

	};

	App.prototype.init = function() {
    var that = this;
    this.object_fit();
	};

	/**
	 * object-fit
	 */
  App.prototype.object_fit = function() {
    objectFitImages()
  };

	return App;

})(jQuery, document, window);

(function($){
	var app = new App();
	window.app = new App();
	app.init();
})(jQuery);
