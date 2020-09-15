<template>
  <div>
    <h2 class="instructions qr-reader-instruction">Phasellus ultrices ligula nec condimentum condimentum. Proin mattis cursus sapien, eget porta nisl vehicula sit amet.</h2>
    <select class="select-camera" name="camera" @change="changeCamera">
      <option 
        v-for="(camera, index) in cameras" 
        :value="index" 
        :key="index">{{ camera.name }}</option>
    </select>
    <video playsinline autoplay controls muted loop id="preview"></video>
    <section class="qr-code-info">
      <div>
        <h3 class="block-title">QR Result</h3>
        <p class="qr-string">{{ QRString }}</p>
      </div>
      <div>
        <h3 class="block-title">Decoded String</h3>
        <p class="qr-string">{{ decodeString }}</p>
      </div>
    </section>
    <button class="step-button form" @click="goToForm">Form</button>
  </div>
</template>

<script>
import Instascan from 'instascan';
import aesjs from 'aes-js'

export default {
  name: 'QRCodeScan',
  data() {
    return {
      QRString: 'Waiting to read QR Code',
      decodeString: 'Waiting for the encrypted code',
      items: [],
      selectedCamera: 0,
      secretKey: 'f%&&#Wum+tvJ/wt5',
      iv: 'XFiimb2WmBKZHaWe',
      cameras: [],
      scanner: null,
      props: {
        QRString: {
          type: String
        },
        decodedString: {
          type: String
        },
        items: {
          type: Array
        }
      }
    }
  },
  methods: {
    init() {
      Instascan.Camera.getCameras().then(cameras => {
        if (cameras.length > 0) {
          this.cameras = cameras;
          this.scanner.start(cameras[this.selectedCamera]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
      this.onRead()
    },
    onRead() {
      this.scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
      this.scanner.addListener('scan', content => {
        this.QRString = content;
        this.decode();
        this.scanner.stop()
      });
    },
    changeCamera(e) {
      const index = parseInt(e.target.value);
      this.scanner.stop();
      Instascan.Camera.getCameras().then(cameras => {
        this.scanner.start(cameras[index]);
        this.selectedCamera = index
      });
    },
    decode() {
      const secret = aesjs.utils.utf8.toBytes(this.secretKey);
      const iv = aesjs.utils.utf8.toBytes(this.iv);

      const encryptedHex = this.base64ToHex(this.QRString)
      const encryptedBytes = aesjs.utils.hex.toBytes(encryptedHex);

      const aesCbc = new aesjs.ModeOfOperation.cbc(secret, iv);
      const decryptedBytes = aesCbc.decrypt(encryptedBytes);

      const decodeString = aesjs.utils.utf8.fromBytes(decryptedBytes)

      // Parse string to array
      this.parse(decodeString)
    },
    parse(str) {
      var newStr = str.replace(/"/g, '')
      this.decodeString = newStr.split(',')
      this.$store.dispatch('setUserData', this.decodeString)
    },
    hexToBase64(str) {
      return btoa(String.fromCharCode.apply(null,
        str.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" "))
      );
    },
    base64ToHex(str) {
      for (var i = 0, bin = atob(str.replace(/[ \r\n]+$/, "")), hex = []; i < bin.length; ++i) {
        var tmp = bin.charCodeAt(i).toString(16);
        if (tmp.length === 1) tmp = "0" + tmp;
        hex[hex.length] = tmp;
      }
      return hex.join('');
    },
    goToForm () {
      this.$emit('goToForm', 'Form')
    }
  },
  mounted() {
    this.init()
  },
}
</script>

<style scoped>
#preview {
  display: block;
  width: 400px;
  height: 400px;
  background: black;
  margin: 0 auto;

}
.qr-reader-instruction {
  padding-bottom: 40px;
}
.block-title {
  background: #eee;
  font-size: 18px;
  font-weight: bold;
  text-align: center;
  padding: 8px;
}
.qr-code-info {
  padding-top: 20px;
  padding-bottom: 20px;
}
.qr-string {
  font-size: 20px;
  background-color: rgb(255, 255, 231);
  border: 1px solid rgb(-0, 147, 118);
  padding: 20px;
}

.form {
  position: absolute;
  right: 47px;
}
</style>