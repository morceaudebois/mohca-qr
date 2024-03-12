/*
 * @Author: super
 * @Date: 2019-06-27 16:29:31
 * @Last Modified by: suporka
 * @Last Modified time: 2020-03-04 12:24:50
 */

import { BaseOptions } from "./model";
import { toCanvas } from "./toCanvas";
import { toImage, saveImage } from "./toImage";
import { version } from '../package.json';

class QrCodeWithLogo {

  static version: string = version

  option: BaseOptions;
  ifCanvasDrawed: boolean = false
  ifImageCreated: boolean = false

  private defaultOption: BaseOptions = {
    canvas: undefined,
    image: undefined,
    content: ''
  }

  constructor(option: BaseOptions) {
    this.option = Object.assign(this.defaultOption, option);
    if (!this.option.canvas) this.option.canvas = document.createElement("canvas")
    if (!this.option.image) this.option.image = document.createElement("img")
    this.toCanvas().then(this.toImage.bind(this))
  }

  private toCanvas(): Promise<void> {
    return toCanvas.call(this, this.option).then(() => {
      this.ifCanvasDrawed = true
      return Promise.resolve()
    })
  };

  private toImage(): Promise<void> {
    return toImage(this.option, this);
  }

  public async downloadImage(name: string = 'qrcode.png') {
    if (!this.ifImageCreated) await this.toImage()
    return saveImage(this.option.image!, name);
  }

  public async getImage(): Promise<HTMLImageElement> {
    if (!this.ifImageCreated) await this.toImage()
    return this.option.image!
  }

  public async getCanvas(): Promise<HTMLCanvasElement> {
    if (!this.ifCanvasDrawed) await this.toCanvas()
    return this.option.canvas!
  }

}

export default QrCodeWithLogo;
