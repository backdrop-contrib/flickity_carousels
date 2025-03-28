/*!
 * Flickity asNavFor v3.0.0
 * enable asNavFor for Flickity
 * Original code by Metafizzy, patched by Indigoxela to fix window resize.
 */

( function( window, factory ) {
  // universal module definition
  if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
        require('flickity'),
        require('fizzy-ui-utils'),
    );
  } else {
    // browser global
    window.Flickity = factory(
        window.Flickity,
        window.fizzyUIUtils,
    );
  }

}( window, function factory( Flickity, utils ) {

// -------------------------- asNavFor prototype -------------------------- //

// Flickity.defaults.asNavFor = null;

Flickity.create.asNavFor = function() {
  this.on( 'activate', this.activateAsNavFor );
  this.on( 'deactivate', this.deactivateAsNavFor );
  this.on( 'destroy', this.destroyAsNavFor );

  let asNavForOption = this.options.asNavFor;
  if ( !asNavForOption ) return;
  this.captureResize();
  // HACK do async, give time for other flickity to be initalized
  setTimeout( () => {
    this.setNavCompanion( asNavForOption );
  } );
};

let proto = Flickity.prototype;

// Custom adaption to get asNavFor working properly with window resize.
proto.captureResize = function () {
  const flkty = this;
  flkty.windowResizing = false;
  // This event fires often, but we need to make sure, we set the state
  // immediately.
  window.addEventListener('resize', function () {
    flkty.windowResizing = true;
  });
  // Does not fire as often. Set propery back after a short while.
  flkty.on('resize', function () {
    setTimeout(function () {
      flkty.windowResizing = false;
    }, 100);
  });
};

proto.setNavCompanion = function( elem ) {
  elem = utils.getQueryElement( elem );
  let companion = Flickity.data( elem );
  // stop if no companion or companion is self
  if ( !companion || companion === this ) return;

  this.navCompanion = companion;
  // companion select
  const flkty = this;
  this.onNavCompanionSelect = () => {
    // Set isInstant to true while resizing.
    this.navCompanionSelect(flkty.windowResizing);
  };
  companion.on( 'select', this.onNavCompanionSelect );
  // click
  this.on( 'staticClick', this.onNavStaticClick );

  this.navCompanionSelect( true );
};

proto.navCompanionSelect = function( isInstant ) {
  // wait for companion & selectedCells first. #8
  let companionCells = this.navCompanion && this.navCompanion.selectedCells;
  if ( !companionCells ) return;

  // select slide that matches first cell of slide
  let selectedCell = companionCells[0];
  let firstIndex = this.navCompanion.cells.indexOf( selectedCell );
  let lastIndex = firstIndex + companionCells.length - 1;
  let selectIndex = Math.floor( lerp( firstIndex, lastIndex,
      this.navCompanion.cellAlign ) );
  this.selectCell( selectIndex, false, isInstant );
  // set nav selected class
  this.removeNavSelectedElements();
  // stop if companion has more cells than this one
  if ( selectIndex >= this.cells.length ) return;

  let selectedCells = this.cells.slice( firstIndex, lastIndex + 1 );
  this.navSelectedElements = selectedCells.map( ( cell ) => cell.element );
  this.changeNavSelectedClass('add');
};

function lerp( a, b, t ) {
  return ( b - a ) * t + a;
}

proto.changeNavSelectedClass = function( method ) {
  this.navSelectedElements.forEach( function( navElem ) {
    navElem.classList[ method ]('is-nav-selected');
  } );
};

proto.activateAsNavFor = function() {
  this.navCompanionSelect( true );
};

proto.removeNavSelectedElements = function() {
  if ( !this.navSelectedElements ) return;

  this.changeNavSelectedClass('remove');
  delete this.navSelectedElements;
};

proto.onNavStaticClick = function( event, pointer, cellElement, cellIndex ) {
  if ( typeof cellIndex == 'number' ) {
    this.navCompanion.selectCell( cellIndex );
  }
};

proto.deactivateAsNavFor = function() {
  this.removeNavSelectedElements();
};

proto.destroyAsNavFor = function() {
  if ( !this.navCompanion ) return;

  this.navCompanion.off( 'select', this.onNavCompanionSelect );
  this.off( 'staticClick', this.onNavStaticClick );
  delete this.navCompanion;
};

// -----  ----- //

return Flickity;

} ) );
