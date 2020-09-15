<template>
  <div class="instructions">
    <div class="complete-instructions">
      <p>Quisque dictum sit amet urna at sollicitudin.</p>
      <p>Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </div>
    <div class="complete-button">
      <button @click="Print" class="step-button">Print</button>
      <button @click="Close" class="step-button">Close</button>
    </div>
  </div>
</template>

<script>
  import { degrees, PDFDocument, rgb, StandardFonts } from 'pdf-lib';
  // import fontkit from '@pdf-lib/fontkit'
  import printJS from 'print-js';
  // import QrcodeVue from 'qrcode.vue';
  // import download from 'downloadjs';

  export default {
    name: 'Complete',
    props: {
      model: {
        type: Object,
      }
    },
    data() {
      return {
        pdfURL: 'dummy.pdf',
        pdfBytes: null,
        font: null,
        pdfDoc: null,
      }
    },
    methods: {
      Close() {
        this.clean()
        this.stepIndexPage = 0
        this.stepNamePage = null
        this.stepIndexPage = 0
        this.stepNamePage = this.stepName
        this.stepIndexPage = this.stepIndex
        this.$emit('Close', 'Welcome')
      },
      clean () {
        this.$emit.radio = null
        this.$store.dispatch('resetData')
      },
      /** When user click Print out button -> open screen for printing */
      Print() {
        var self = this;
        self.updatePDF((res) => {
          const newPdfBytes = res;
          const bin = String.fromCharCode.apply(null, newPdfBytes);
          console.log(bin)
          const base64 = btoa(bin);
          printJS({printable: base64, type: 'pdf', base64: true});
        })
      },
      updatePDF(callback) {
        const pages = this.pdfDoc.getPages();

        const firstPage = pages[0];
        const { height } = firstPage.getSize()
        var text = `
          Date of Visit: ${ this.model.moveDay.year },${ this.model.moveDay.month },${ this.model.moveDay.day }\n
          Name: ${ this.model.demanderName.lastname }, ${ this.model.demanderName.firstname }\n
          Company Name: ${ this.model.companyName }\n
          Phone Number: ${ this.model.createPhoneNumber }\n

        `
        firstPage.drawText(text, {
          x: 7,
          y: height / 2 + 200,
          size: 14,
          font: this.font,
          color: rgb(0, 0, 0),
          rotate: degrees(0),
        })
        this.pdfDoc.save().then((res) => {
          callback(res);
        });
      },
    },
    mounted() {
      fetch(this.pdfURL).then(res => {
        res.arrayBuffer().then((buffer) => {
            this.pdfBytes = buffer;
            PDFDocument.load(this.pdfBytes).then(res => {
                this.pdfDoc = res;
                this.pdfDoc.embedFont(StandardFonts.Helvetica).then(res => {
                    this.font = res;
                });
            });
        });
    });
  }
}
</script>

<style lang="sass" scoped>
.complete-button
  display: flex
  justify-content: space-around
  position: relative
  top: 520px

.complete-.instructions
  padding-bottom: 640px

@media print 
  button
    visibility: hidden
</style>