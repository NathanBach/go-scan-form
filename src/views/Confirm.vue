<template>
  <div id='confirmation-page' class="page-content confirm-page">
    <ul class="head-instructions">
      <li>
        <p class="text-jp">
          入力内容を確認して、一番下の「QRコード作成」を押してください。
        </p>
        <p class="text-en">
          Confirm your information and press the "Create a QR Code"
          button.
        </p>
      </li>
      <li>
        <p class="text-jp">
          修正する場合は、「戻る」をクリックしてください。
        </p>
        <p class="text-en">
          To revise your entry, click "Back" at the bottom.
        </p>
      </li>
    </ul>

    <div class="form-fields">
      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">来庁日 </span>
          <span class="en">Date of Visit</span>
        </h2>
        <div class="content">
          <div class="row d-flex">
            <div class="input-data">
              {{ model.moveDay.year }}年{{ model.moveDay.month }}月{{ model.moveDay.day }}日
            </div>
          </div>
        </div>
      </section>
      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">氏名 </span>
          <span class="en">Name</span>
        </h2>
        <div class="content">
          <div class="group">
            <div class="input-data">
              <p>
                {{ model.demanderName.lastname }} {{ model.demanderName.firstname }}
              </p>
             <p class="input-data">{{ model.demanderNameKata.firstname }} {{ model.demanderNameKata.lastname }}</p>
          </div>
        </div>
      </div>
      </section>
      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">会社・団体名 </span>
          <span class="en">Company Name</span>
        </h2>
        <div class="content">
          <div class="row" v-if="!individuals">
            <div class="input-data">{{ model.companyName }}</div>
          </div>
          <div class="row" v-if="individuals">
            <div class="item">
              <label class="item-checkbox no-check">
                <span class="text-label inline"
                  ><span class="jp">個人 </span
                  ><span class="en">Personal</span></span
                >
              </label>
            </div>
          </div>
        </div>
      </section>

      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">電話番号 </span>
          <span class="en">Phone Number</span>
        </h2>
        <div class="content">
          <div class="row" v-if="!noPhoneNumber">
            <div class="input-data">
              {{ model.createPhoneNumber }}
            </div>
          </div>
          <div class="row" v-if="noPhoneNumber">
            <div class="item">
              <label class="item-checkbox no-check">
                <span class="text-label inline"
                  ><span class="jp">保有していない </span
                  ><span class="en">No phone number</span></span
                >
              </label>
            </div>
          </div>
        </div>
      </section>
      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">訪問先 </span>
          <span class="en">Destinations(s)</span>
        </h2>
        <div class="content">
          <div class="item" v-if="model.createReCounter[0]">
            <label class="item-checkbox no-check">
              <span class="text-label inline">
                <span class="jp">都民情報ルーム </span>
                <span class="en">Citizens' Information Room</span></span
              >
            </label>
          </div>
          <div class="item" v-if="model.createReCounter[1]">
            <label class="item-checkbox no-check">
              <span class="text-label inline"
                ><span class="jp">都民の声窓口 </span
                ><span class="en"
                  >Citizens' Consultation Section</span
                ></span
              >
            </label>
          </div>
          <div class="item" v-if="model.createReCounter[2]">
            <label class="item-checkbox no-check">
              <span class="text-label inline"
                ><span class="jp">２庁３階-不動産業課 </span
                ><span class="en"
                  >Realty Section, 3rd floor, 2nd bldg.</span
                ></span
              >
            </label>
          </div>
          <div class="item" v-if="model.createReCounter[3]">
            <label class="item-checkbox no-check">
              <span class="text-label inline"
                ><span class="jp">２庁３階-市街地建築部 </span
                ><span class="en"
                  >Urban Building Division, 3rd floor, 2nd bldg.</span
                ></span
              >
            </label>
          </div>

          <div class="item" v-if="officeSectionName">
            <label class="item-checkbox no-check">
              <span class="text-label"
                ><span class="jp">上記以外の局・部署（選択） </span
                ><span class="en"
                  >Other department(s) （selection）</span
                ></span
              >
            </label>
          </div>

          <div class="group-checkbox-padding" v-if="officeSectionName">
            <div class="group-select result-select">
              <div class="row" v-if="bureauName1.length">
                <div class="item">
                  <div class="input-data has-number">
                    <span class="number">①</span>
                    <div
                      class="item-select-result"
                      v-html="findFullNameSelect(bureauName1, 1)"
                    ></div>
                    <div
                      class="item-select-result"
                      v-html="findFullNameSelect(departmentName1, 2)"
                    ></div>
                  </div>
                </div>
              </div>
              <div class="row" v-if="bureauName2.length">
                <div class="item">
                  <div class="input-data has-number">
                    <span class="number">②</span>
                    <div
                      class="item-select-result"
                      v-html="findFullNameSelect(bureauName2, 1)"
                    ></div>
                    <div
                      class="item-select-result"
                      v-html="findFullNameSelect(departmentName2, 2)"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="item" v-if="model.createReCounter[4]">
            <label class="item-checkbox no-check">
              <span class="text-label inline"
                ><span class="jp">食堂 </span
                ><span class="en">Cafeteria</span></span
              >
            </label>
          </div>
          <div class="item" v-if="model.createReCounter[5]">
            <label class="item-checkbox no-check">
              <span class="text-label inline"
                ><span class="jp">会議室・診療所・売店等 </span
                ><span class="en"
                  >Conference rooms,clinic,shops</span
                ></span
              >
            </label>
          </div>
          <div class="item" v-if="isVisitPlaceOther">
            <label class="item-checkbox no-check">
              <span class="text-label inline"
                ><span class="jp">その他</span
                ><span class="en">Other</span></span
              >
            </label>
          </div>
          <div class="group-checkbox-padding">
            <div class="item" v-if="isVisitPlaceOther">
              <div class="input-data">{{ visitPlaceOther }}</div>
            </div>
          </div>
        </div>
      </section>

      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">当日中の再入庁 </span>
          <span class="en">Re-entry on the day</span>
        </h2>
        <div class="content">
          <div class="row">
            <ul class="list-radio">
              <li class="item" v-if="model.tempReEntry == '1'">
                <span class="text-label"
                  ><span class="jp">有 </span
                  ><span class="en">Yes</span></span
                >
              </li>
              <li class="item" v-if="model.tempReEntry == '0'">
                <span class="text-label"
                  ><span class="jp">無 </span
                  ><span class="en">No</span></span
                >
              </li>
            </ul>
          </div>
        </div>
      </section>
      <section class="section-category">
        <h2 class="title-item">
          <span class="jp">同伴者人数 </span>
          <span class="en">Number of accompanying visitors</span>
        </h2>
        <div class="content">
          <div class="row">
            <ul class="list-radio">
              <li class="item">
                <span class="text-label"
                  ><span class="jp">{{
                    model.numAccompany
                  }}</span></span
                >
              </li>
            </ul>
          </div>
        </div>
      </section>

      <section
        class="section-category"
        v-if="Number(model.numAccompany) > 0">
        <h2 class="title-item">
          <span class="jp">同伴者 </span>
          <span class="en">Accompanying visitor</span>
        </h2>
        <div class="content">
          <div class="row">
            <div class="item">
              <label class="text-label">
                <span class="number">① </span>
                <span class="en">{{ model.otherPeople.people1.lastname }} {{ model.otherPeople.people1.firstname }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>
      <section
        class="section-category"
        v-if="Number(model.numAccompany) > 1">
        <div class="content">
          <div class="row">
            <div class="item">
              <label class="text-label">
                <span class="number">② </span>
                <span class="en">{{ model.otherPeople.people2.lastname }} {{ model.otherPeople.people2.firstname }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>
      <section
        class="section-category"
        v-if="Number(model.numAccompany) > 2">
        <div class="content">
          <div class="row">
            <div class="item">
              <label class="text-label">
                <span class="number">③ </span>
                <span class="en">{{ model.otherPeople.people3.lastname }} {{ model.otherPeople.people3.firstname }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>
      <section
        class="section-category"
        v-if="Number(model.numAccompany) > 3">
        <div class="content">
          <div class="row">
            <div class="item">
              <label class="text-label">
                <span class="number">④ </span>
                <span class="en">{{ model.otherPeople.people4.lastname }} {{ model.otherPeople.people4.firstname }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>
      <section
        class="section-category"
        v-if="Number(model.numAccompany) > 4">
        <div class="content">
          <div class="row">
            <div class="item">
              <label class="text-label">
                <span class="number">⑤ </span>
                <span class="en">{{ model.otherPeople.people5.lastname }} {{ model.otherPeople.people5.firstname }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>
      <section
        class="section-category"
        v-if="Number(model.numAccompany) > 5">
        <div class="content">
          <div class="row">
            <div class="item">
              <label class="text-label">
                <span class="number">⑥ </span>
                <span class="en">{{ model.otherPeople.people6.lastname }} {{ model.otherPeople.people6.firstname }}</span>
              </label>
            </div>
          </div>
        </div>
      </section>
      <div class="block-text-final-desc">
        <p class="jp">
          本受付データは、都又は警備業務実施事業者が適切に廃棄・消去いたします。<br />ただし、庁内管理者において、一時通行証の返却確認や、庁舎内にて犯罪行為等が発生した場合における検査及び身元確認のため、当該個人情報を利用することがありますので、予めご了承願います。
        </p>
        <p class="en">
          This form data will be appropriately deleted by TMG or security
          company. However, personal information may be used for criminal
          investigation and so on. We thank your understanding and
          cooperation.
        </p>
      </div>
      <!-- <qrcode-vue></qrcode-vue> -->
    </div>

    <div class="page-content">
      <ul class="list-instructions">
        <li>
          <p class="text-jp">
            以下のQRコードを受付へご提示ください。<br />このままの画面、または、スクリーンショットで保存した画像をご提示ください。（スクリーンショットの撮り方は、下の「保存方法」をご参照ください。）
          </p>
          <p class="text-en">
            Please take this (or saved) QR Code to the reception desk.<br />
            (Please refer to "How to take a screenshot" below.)
          </p>
        </li>
        <li>
          <p class="text-jp">
            パソコン等から紙に印刷したQRコードを受付へお持ちいただいても結構です。
          </p>
          <p class="text-en">
            You can also use the printed QR Code on paper.
          </p>
        </li>
      </ul>
      <div class="qr-code-image">
        <qrcode-vue :value="qrValue" :size="size" level="H"></qrcode-vue>
      </div>
      
      <!-- <button class="step-button" @click="writeDB">Write DB</button> -->
      <!-- <button class="step-button" @click="Print">Print</button> -->
      <button class="step-button button confirm-button" @click="Complete">Complete</button>
    </div>
  </div>
</template>

<script>
// library for custom font
import fontkit from '@pdf-lib/fontkit' 

// library for printing
import printJS from 'print-js';
import QrcodeVue from 'qrcode.vue';

// library for download
import download from 'downloadjs';
// import { degrees, PDFDocument, rgb, StandardFonts } from 'pdf-lib';
import { degrees, PDFDocument, rgb } from 'pdf-lib';

export default {
  name: 'Confirm',
  components: {
    QrcodeVue,
  },
  props: {
    model: {
      type: Object
    }
  },
  data() {
    return {
      pdfURL: 'dummy.pdf',
      pdfBytes: null,
      font: null,
      pdfDoc: null,
      text: 'HELLO WORLD!!!!!!',
      schema: {},
      formOptions: {},
      visitor: [],
      isEditing: false,
      num_of_accompany: 0,
      noPhoneNumber: false,
      daysOff: null,
      thisYear: 0,
      nextYear: 0,
      listOfDay: [],
      listOfMonth: [],
      bureauName1: '',
      departmentName1: '',
      bureauName2: '',
      departmentName2: '',
      isVisitPlaceOther: false,
      visitPlaceOther: '',
      createReCounter: [],
      updateReCounter: [],
      listDestinations: [],
      destinationCheck1: false,
      destinationCheck2: false,
      destinationCheck3: false,
      destinationCheck4: false,
      destinationCheck5: false,
      destinationCheck6: false,
      officeSectionName: false,
      bureauNameSelect: [],

      size: 0,
      qrValue: '',

      accompanyingPersons: '0',
      realAccompanyingPersons: 0,
      // arrAccompanyingPersons: [],
      otherPeople: {
          person1: {
            firstname: '',
            lastname: ''
          },
          person2: {
            firstname: '',
            lastname: ''
          },
          person3: {
            firstname: '',
            lastname: ''
          },
          person4: {
            firstname: '',
            lastname: ''
          },
          person5: {
            firstname: '',
            lastname: ''
          },
          person6: {
            firstname: '',
            lastname: ''
          }
        },

      departmentNameSelect: [],
      departmentNameSelect1: [],
      departmentNameSelect2: [],
      individuals: false,
      numAccompany: 0,
      errors: {
        atLeastVisitPlace: false,
        bureauName1: false,
        departmentName1: false,
        departmentName2: false,
        visitPlaceOther: false,
        sameBureauDivisionName: false
      },
    }
  },
  methods: {
    Complete () {
      var self = this
      self.Print()
      // self.updatePDFPrint()
      self.writeDB()
      // self.CompletePage()
      self.$emit('getModel', self.model)
      self.downloadPDF()
    }, 

    updatePDF(callback) {
      const pages = this.pdfDoc.getPages();

      const firstPage = pages[0];
      const { height } = firstPage.getSize()
     
      var text = `
        入力内容を確認して、一番下の「QRコード作成」を押してください。
        Confirm your information and press the "Create a QR Code" button.

        修正する場合は、「戻る」をクリックしてください。
        To revise your entry, click "Back" at the bottom.

        氏名  Name: 
        ${ this.model.demanderName.lastname }, ${ this.model.demanderName.firstname }
        ${ this.model.demanderNameKata.lastname }, ${ this.model.demanderNameKata.firstname }

        来庁日  Date of Visit: 
        ${ this.model.moveDay.year }年, ${ this.model.moveDay.month }月, ${ this.model.moveDay.day }日

        会社・団体名  Company Name: 
        ${!this.individuals ? `${ this.model.companyName }` : ""}

        電話番号  Phone Number: 
        ${!this.noPhoneNumber ? `${ this.model.createPhoneNumber }` : ""}

        同伴者人数  Number of accompanying visitors:
        ${ this.model.numAccompany }

        同伴者  Accompanying Visitors: 
        ${ Number(this.model.numAccompany) > 0 ? `${ this.model.otherPeople.people1.lastname }, ${ this.model.otherPeople.people1.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 1 ? `${ this.model.otherPeople.people2.lastname }, ${ this.model.otherPeople.people2.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 2 ? `${ this.model.otherPeople.people3.lastname }, ${ this.model.otherPeople.people3.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 3 ? `${ this.model.otherPeople.people4.lastname }, ${ this.model.otherPeople.people4.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 4 ? `${ this.model.otherPeople.people5.lastname }, ${ this.model.otherPeople.people5.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 5 ? `${ this.model.otherPeople.people6.lastname }, ${ this.model.otherPeople.people6.firstname }` : " "}

        訪問先  Destinations:
        ${ this.model.createReCounter[0] ? `${ this.model.createReCounter[0]}` : "" }
        ${ this.model.createReCounter[1] ? `${ this.model.createReCounter[1]}` : "" }
        ${ this.model.createReCounter[2] ? `${ this.model.createReCounter[2]}` : "" }
        ${ this.model.createReCounter[3] ? `${ this.model.createReCounter[3]}` : "" }
        ${ this.model.createReCounter[4] ? `${ this.model.createReCounter[4]}` : "" }
        ${ this.model.createReCounter[5] ? `${ this.model.createReCounter[5]}` : "" }

        Other department(s) （selection）:
        ${this.bureauName1.length ? ` ${this.findFullNameSelect(this.bureauName1, 1)}, ${this.findFullNameSelect(this.departmentName1, 2)}` : ""}
        ${this.bureauName2.length ? ` ${this.findFullNameSelect(this.bureauName2, 1)}, ${this.findFullNameSelect(this.departmentName2, 2)}` : ""}

        Re-Entry:
        ${this.model.tempReEntry == '1' ? "Yes" : "No"}

        本受付データは、都又は警備業務実施事業者が適切に廃棄・消去いたします。
        ただし、庁内管理者において、一時通行証の返却確認や、庁舎内にて犯罪行為等が発生した場合における検査及び身元確認のため、当該個人情報を利用することがありますので、予めご了承願います。
        This form data will be appropriately deleted by TMG or security company. However, personal information may be used for criminal investigation and so on. We thank your understanding and cooperation.

        以下のQRコードを受付へご提示ください。
        このままの画面、または、スクリーンショットで保存した画像をご提示ください。（スクリーンショットの撮り方は、下の「保存方法」をご参照ください。）
        Please take this (or saved) QR Code to the reception desk.
        (Please refer to "How to take a screenshot" below.)

        パソコン等から紙に印刷したQRコードを受付へお持ちいただいても結構です。
        You can also use the printed QR Code on paper.
        `
      firstPage.drawText(text, {
        x: 7,
        y: height / 2 + 320,
        size: 14,
        font: this.font,
        color: rgb(0, 0, 0),
        rotate: degrees(0),
      })
      this.pdfDoc.save().then((res) => {
        callback(res);
      })
    },

     /** When user click Print out button -> open screen for printing */
    Print() {
      var self = this;
      self.updatePDF((res) => {
        // console.log(res)
        // const newPdfBytes = res;
        let bin = String.fromCharCode.apply(null, res);
        console.log(bin)
        const base64 = btoa(bin);
        printJS({printable: base64, type: 'pdf', base64: true, showModal:true});
      })
    },

    downloadPDF() {
    this.updatePDF((res) => {
      const newPdfBytes = res;
      // console.log(res);
      download(newPdfBytes, 'Confirmation.pdf', 'application/pdf');
      })
    },

    writeDB() {
    var self = this
    var moveYear = self.model.moveDay.year
    var moveMonth = self.model.moveDay.month < 10 ? '0' + self.model.moveDay.month : self.model.moveDay.month
    var moveDay = self.model.moveDay.day < 10 ? '0' + self.model.moveDay.day : self.model.moveDay.day

    var people = ''
    for (let i = 1; i <= 6; i++) {
      if (self.model.otherPeople['person' + i].lastname !== '' || self.model.otherPeople['person' + i].firstname !== '') {
        people += `"person${i}": {
          "lastname": "${self.model.otherPeople['person' + i].lastname}",
          "firstname": "${self.model.otherPeople['person' + i].firstname}"
        },`
      }
    }
    const data = `{
      "user_data": {
        "people": {
          ${people.substr(0, people.length - 1)}
        },
        "version": "1",
        "language": "0",
        "device_id": "0000",
        "move_date": "${moveYear.toString() + moveMonth.toString() + moveDay.toString()}",
        "company_name": "${self.model.companyName}",
        "demander_name": {
          "lastname": "${self.model.demanderName.lastname}",
          "firstname": "${self.model.demanderName.firstname}"
        },
        "demander_name_kata": {
          "lastname": "${self.model.demanderNameKata.lastname}",
          "firstname": "${self.model.demanderNameKata.firstname}"
        },
        "temp_re_entry": "${self.model.tempReEntry}",
        "create_deman_date": "${self.model.createDemanDate}",
        "create_re_counter": "${self.model.createReCounter.toString().replaceAll(',', '/')}",
        "create_phone_number": "${self.model.createPhoneNumber}"
      },
      "section_name": "${self.$store.state.counter}",
      "form_name": "FORM",
      "action": "${self.action}"
    }`
    // console.log(data)

    self.$http
      .post('http://swt033-fcr173-nathan-nhan:8888/create.php', data, {responseType: 'json'})
      .then( successCallback => {
        return successCallback.body
      }, errorCallback => {
        console.log(errorCallback)
      })
    },
      CompletePage() {
      var self = this
      self.$emit("goToComplete", "Complete")
    },
    
  },
  mounted() {
    fetch(this.pdfURL).then((res) => {
      res.arrayBuffer().then((buffer) => {
        this.pdfBytes = buffer;
        PDFDocument.load(this.pdfBytes).then(res => {
          this.pdfDoc = res;
          this.pdfDoc.registerFontkit(fontkit)
          // const fontUrl = './fonts/HIRAGANA.TTF';
          const fontUrl = './fonts/Meiryo.woff2';
          // const fontUrl = './fonts/姫明朝しらゆきmini.otf';
          fetch(fontUrl).then(res => res.arrayBuffer()).then(ab => {
            const font = new Buffer(ab);
            this.pdfDoc.embedFont(font).then((font) => {
              this.font = font;
            });
          });
        });
      });
    });
  }
}
</script>

<style lang="sass" scoped>
.head-instructions
  padding: 0 0 18px

.confirm-page
  text-align: left

.confirm-page
  padding-top: 40px

.confirm-button
  position: absolute
  right: 20px


.title-item
  background-color: rgb(-0, 147, 118)
  color: white
  font-weight: bold
  font-size: 16px
  padding: 10px

.input-data, .item
  padding: 10px

@media print 
  button
    visibility: hidden
</style>