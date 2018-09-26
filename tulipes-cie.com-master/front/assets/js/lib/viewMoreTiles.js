import $ from 'jquery';

const btnViewMore = $(".btn-view-more");
const tiles = $(".view-more-tile");

export default function viewMoreTiles(numberTilesDisp) {
if (window.matchMedia("(max-width: 991px)").matches) {
  /* s'il y a un raison d'afficher le bouton */
  if (tiles.length <= numberTilesDisp) {
    btnViewMore.hide();
  } else {
    /* masque les tuiles en plus */
    for (let i = numberTilesDisp; i < tiles.length; i++) {
      $(tiles[i]).addClass("tile-hide");
    }

    /* action du boutton afficher plus*/
    btnViewMore.click(function () {
      let hiddenTiles = $(".tile-hide");
      let numberTilesHide = numberTilesDisp;

      if (hiddenTiles.length < numberTilesDisp) {
        numberTilesHide = hiddenTiles.length;
      }

      for (let i = 0; i < numberTilesHide; i++) {
        $(hiddenTiles[i]).slideDown();
        $(hiddenTiles[i]).removeClass("animated tile-hide");
      }

      if (!tiles.hasClass("tile-hide")) {
        btnViewMore.hide();
      }
    });
  }

}
}