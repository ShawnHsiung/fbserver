/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var initialData = [
    { artistId: 87, artistName: "Joe" },
    { artistId: 22, artistName: "Bob" },
    { artistId: 34, artistName: "Mary" },
    { artistId: 7, artistName: "John" },
    { artistId: 19, artistName: "Bill" },
    { artistId: 52, artistName: "Tom" },
    { artistId: 95, artistName: "George" },
    { artistId: 8, artistName: "Jim" }

]; 

var my = my || {};

my.Artist = function () {
  var self = this; 
  self.artistId = ko.observable();
  self.artistName = ko.observable();
  self.getTheArtist = function () {
    alert( "Id: " + self.artistId() + ", " + self.artistName());
  };
};

my.VM = function () {
  var Artists = ko.observableArray([]),
      load_initialData = function( _initialData ) {
        // clear array if loading dynamic data
        Artists([]);
        
        $.each( _initialData, function( i, d ) {
          Artists.push( new my.Artist()
            .artistId(d.artistId)
            .artistName(d.artistName)
          );
        });
        
      };
  return {
    load_initialData: load_initialData,
    Artists: Artists
  };
}();

$(function() {
  my.VM.load_initialData( initialData );
  ko.applyBindings( my.VM );
});

my.VM.artist_selected = ko.observable();
my.VM.artist_selected.subscribe(function (newValue) {
  alert("artistId: " + newValue);
});