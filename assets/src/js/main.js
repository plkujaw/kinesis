// import Carousel from './modules/Carousel';
import MobileMenu from './modules/MobileMenu';

const mobileMenu = new MobileMenu();
// const carousel = new Carousel();

const allowedBlocks = [
  'core/image',
  'core/media-text',
  'acf/block-name',
  'acf/other-block-name',
  'core/paragraph',
];

wp.domReady(function () {
  wp.blocks.getBlockTypes().forEach(function (blockType) {
    if (allowedBlocks.indexOf(blockType.name) === -1) {
      wp.blocks.unregisterBlockType(blockType.name);
    }
  });
});
