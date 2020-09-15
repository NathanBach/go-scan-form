<template>
  <div id='form-page'>
    <form action="/">
      <vue-form-generator :schema="schema" :model="model" :options="formOptions" ref="form"></vue-form-generator>

      <section class="section-category vue-form-generator">
        <h2 class="title-item">訪問先</h2>
        <div class="content">
          <p class="desc">※複数選択可</p>
          <div class="list-checkbox" :class="{'error': errors.atLeastVisitPlace}">
            <p class="alert-text" v-if="errors.atLeastVisitPlace">エラー：選択してください。</p>
            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" value="都民情報ルーム" v-model="destinationCheck1" @change="updateReCounter('atLeastVisitPlace')">
                <span class="text-label">都民情報ルーム</span>
              </label>
            </div>
            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" value="都民の声窓口" v-model="destinationCheck2" @change="updateReCounter('atLeastVisitPlace')">
                <span class="text-label">都民の声窓口</span>
              </label>
            </div>
            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" value="不動産業課" v-model="destinationCheck3" @change="updateReCounter('atLeastVisitPlace')">
                <span class="text-label">２庁３階 不動産業課</span>
              </label>
            </div>
            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" value="市街地建築部" v-model="destinationCheck4" @change="updateReCounter('atLeastVisitPlace')">
                <span class="text-label">２庁３階 市街地建築部</span>
              </label>
            </div>

            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" v-model="officeSectionName" @change="removeValid('atLeastVisitPlace')">
                <span class="text-label">上記以外の局・部署（選択）</span>
              </label>
            </div>

            <div class="group-checkbox" :class="{error: errors.sameBureauDivisionName}" v-if="officeSectionName">
              <div class="form-group col-6" :class="{'error': errors.bureauName1}">
                <span class="text-label">局選択1</span>
                <select class="form-control" v-model="bureauName1" @change="changeBureauName(1); validAfterSelectDivision(); updateReCounter('bureauName1');">
                  <option value="">選択してください</option>
                  <option v-for="(option, index) in bureauNameSelect" :key="index" :value="option.sortName">{{ formatCSVOutput(option.name) }}</option>
                </select>
                <p class="alert-text" v-if="errors.bureauName1">エラー：選択してください。</p>
              </div>
              <div class="form-group col-6" :class="bureauName1 == '' ? 'disabled' : ''">
                <label class="text-label">部選択1 </label>
                <select class="form-control" v-model="departmentName1" @change="validAfterSelectDivision(); updateReCounter()">
                  <option value="">選択してください</option>
                  <option v-for="(department1, index) in departmentNameSelect1" :key="index" :value="department1.sortName">{{ formatCSVOutput(department1.name) }}</option>
                </select>
                <p class="alert-text" v-if="errors.departmentName1">エラー：選択してください。</p>
              </div>

              <div class="form-group col-6">
                <label class="text-label">局選択2</label>
                <select class="form-control" v-model="bureauName2" @change="changeBureauName(2); validAfterSelectDivision(); updateReCounter()">
                  <option value="">選択してください</option>
                  <option v-for="(option, index) in bureauNameSelect" :key="index" :value="option.sortName">{{ formatCSVOutput(option.name) }}</option>
                </select>
              </div>
              <div class="form-group col-6" :class="bureauName2 == '' ? 'disabled' : ''">
                <label class="text-label">部選択2</label>
                <select class="form-control" v-model="departmentName2" @change="validAfterSelectDivision(); updateReCounter()">
                  <option value="">選択してください</option>
                  <option v-for="(department2, index) in departmentNameSelect2" :key="index" :value="department2.sortName">{{ formatCSVOutput(department2.name) }}</option>
                </select>
                <p class="alert-text" v-if="errors.departmentName2">エラー：選択してください。</p>
                <p class="alert-text" v-if="errors.sameBureauDivisionName">エラー：同じ訪問先が選択されています</p>
              </div>
            </div>

            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" value="食堂" v-model="destinationCheck5" @change="updateReCounter('atLeastVisitPlace')">
                <span class="text-label">食堂</span>
              </label>
            </div>
            <div class="item">
              <label class="item-checkbox">
                <input type="checkbox" value="会議室" v-model="destinationCheck6" @change="updateReCounter('atLeastVisitPlace')">
                <span class="text-label">会議室・診療所・売店等</span>
              </label>
            </div>
            <div class="item no-min-height">
              <label class="item-checkbox">
                <input type="checkbox" value="その他" v-model="isVisitPlaceOther" @change="removeValid('atLeastVisitPlace')">
                <span class="text-label">その他</span>
              </label>
            </div>
          </div>
          <div class="item form-group" :class="{disabled: !isVisitPlaceOther, error: (isVisitPlaceOther && errors.visitPlaceOther)}">
            <input class="form-control" type="text" placeholder="入力してください" autocomplete="off" v-model="visitPlaceOther" :disabled="isVisitPlaceOther == false" @keyup="updateReCounter('visitPlaceOther')">
          </div>
          <p class="alert-text" v-if="isVisitPlaceOther && errors.visitPlaceOther">エラー：入力してください。</p>
        </div>
        <!-- end list-checkbox -->
      </section>
      <p class="text-right"><input type="button" @click="check" :value="$t('nextPage')" class="btn"></p>
    </form>
  </div>
</template>

<script>
import Vue from 'vue'
import VueFormGenerator from 'vue-form-generator'
import 'vue-form-generator/dist/vfg.css'

Vue.use(VueFormGenerator)

export default {
  name: 'Form',
  data() {
    let currentYear = new Date().getFullYear()
    let currentMonth = new Date().getMonth() + 1
    let currentDay = new Date().getDate()
    return {
      model: {
        moveDay: {
          year: currentYear,
          month: currentMonth,
          day: currentDay
        },
        createDemanDate: '',
        demanderName: {
          lastname: '',
          firstname: ''
        },
        demanderNameKata: {
          lastname: '',
          firstname: ''
        },
        companyName: '',
        noPhoneNumber: false,
        createPhoneNumber: '',
        tempReEntry: '1',
        createReCounter: [],
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
        individuals: false,
        numAccompany: 0
      },
      schema: {},
      formOptions: {},
      visitor: [],
      isEditing: false,
      num_of_accompany: 0,
      daysOff: null,
      thisYear: 0,
      nextYear: 0,
      year: 0,
      month: 0,
      day: 0,
      listOfDay: [],
      listOfMonth: [],
      bureauName1: '',
      departmentName1: '',
      bureauName2: '',
      departmentName2: '',
      isVisitPlaceOther: false,
      visitPlaceOther: '',
      destinationCheck1: false,
      destinationCheck2: false,
      destinationCheck3: false,
      destinationCheck4: false,
      destinationCheck5: false,
      destinationCheck6: false,
      officeSectionName: false,
      bureauNameSelect: [],
      departmentNameSelect: [],
      departmentNameSelect1: [],
      departmentNameSelect2: [],
      errors: {
        atLeastVisitPlace: false,
        bureauName1: false,
        departmentName1: false,
        departmentName2: false,
        visitPlaceOther: false,
        sameBureauDivisionName: false
      }
    }
  },
  methods: {
    init() {
      var self = this
      self.build()
    },

    build() {
      var self = this
      var userData = {}

      // check if have user in global store
      if (self.$store.state.userData.demander_name) {
        userData = JSON.parse(JSON.stringify(self.$store.state.userData))
        self.fillData(userData)
      }

      self.schema = {
        groups: [
          {
            legend: '氏名',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '姓（漢字）',
                model: 'demanderName.lastname',
                required: true,
                validator: VueFormGenerator.validators.string,
                styleClasses: 'col-6',
                onChanged() {
                  self.fillDB()
                }
              },
              {
                type: 'input',
                inputType: 'text',
                label: '名（漢字）',
                model: 'demanderName.firstname',
                required: true,
                validator: VueFormGenerator.validators.string,
                styleClasses: 'col-6',
                onChanged() {
                  self.fillDB()
                }
              },
              {
                type: 'input',
                inputType: 'text',
                label: '姓（カナ）',
                model: 'demanderNameKata.lastname',
                styleClasses: 'col-6',
                onChanged() {
                  self.fillDB()
                }
              },
              {
                type: 'input',
                inputType: 'text',
                label: '名（カナ）',
                model: 'demanderNameKata.firstname',
                styleClasses: 'col-6',
                onChanged() {
                  self.fillDB()
                }
              },
            ]
          },{
            legend: '来庁日',
            fields: [
              {
                type: 'select',
                label: '年',
                model: 'moveDay.year',
                selectOptions: {
                  hideNoneSelectedText: true
                },
                onChanged () {
                  self.makeListOfMonthDay('year')
                },
                values: function() {
                  return [self.year, self.nextYear]
                },
                styleClasses: ['col-4']
              },
              {
                type: 'select',
                label: '月',
                model: 'moveDay.month',
                selectOptions: {
                  hideNoneSelectedText: true
                },
                onChanged () {
                  self.makeListOfMonthDay('month')
                },
                values: function() {
                  return self.listOfMonth
                },
                styleClasses: ['col-4']
              },
              {
                type: 'select',
                label: '日',
                model: 'moveDay.day',
                values: function() {
                  return self.listOfDay
                },
                selectOptions: {
                  hideNoneSelectedText: true
                },
                styleClasses: ['col-4']
              }
            ]
          },{
            legend: '会社・団体名',
            fields: [
              {
                type: 'checkbox',
                label: '個人',
                model: 'individuals',
                default: false,
                styleClasses: ['check-inline'],
                id: 'individual',
                onChanged(model) {
                  if (model.individuals === true) {
                    model.companyName = ''
                    self.isEditing = false
                  }
                }
              },
              {
                type: 'input',
                inputType: 'text',
                label: '会社・団体名',
                model: 'companyName',
                required: function (model) {
                  if (model.individuals === false) {
                    return true
                  }
                },
                disabled: function (model) {
                  if (model.individuals === true) {
                    return true
                  }
                },
                validator: VueFormGenerator.validators.string
              }
            ]
          },{
            legend: '電話番号',
            fields: [
              {
                type: 'checkbox',
                label: '保有していない',
                model: 'noPhoneNumber',
                default: false,
                styleClasses: ['check-inline'],
                id: 'no-phone',
                onChanged(model) {
                  if (model.noPhoneNumber === true) {
                    model.createPhoneNumber = ''
                    self.isEditing = false
                  }
                }
              },
              {
                type: 'input',
                inputType: 'tel',
                label: '電話番号',
                model: 'createPhoneNumber',
                required: function (model) {
                  if (model.noPhoneNumber === false) {
                    return true
                  }
                },
                disabled: function (model) {
                  if (model.noPhoneNumber === true) {
                    return true
                  }
                },
                validator: VueFormGenerator.validators.string
              }
            ]
          },{
            legend: '当日中の再入庁',
            fields: [
              {
                type: 'radios',
                model: 'tempReEntry',
                values: [
                  {name: '有', value: '1'},
                  {name: '無', value: '0'}
                ]
              }
            ]
          },{
            legend: '同伴者人数',
            fields: [{
              type: 'radios',
              model: 'numAccompany',
              values: [0,1,2,3,4,5,6],
              onChanged: function (model) {
                var currentNum = model.numAccompany
                self.updateNumAccompany(currentNum)
              }
            }]
          }, {
            legend: '同伴者1',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '名',
                model: 'otherPeople.person1.firstname',
                visible: function (model) {
                  return model.numAccompany > 0
                },
                styleClasses: 'col-6',
                placeholder: '例） 太郎　Taro'
              }, {
                type: 'input',
                inputType: 'text',
                label: '姓',
                model: 'otherPeople.person1.lastname',
                visible: function (model) {
                  return model.numAccompany > 0
                },
                styleClasses: 'col-6',
                placeholder: '例） 山田　Yamada'
              }
            ]
          }, {
            legend: '同伴者2',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '名',
                model: 'otherPeople.person2.firstname',
                visible: function (model) {
                  return model.numAccompany > 1
                },
                styleClasses: 'col-6',
                placeholder: '例） 太郎　Taro'
              }, {
                type: 'input',
                inputType: 'text',
                label: '姓',
                model: 'otherPeople.person2.lastname',
                visible: function (model) {
                  return model.numAccompany > 1
                },
                styleClasses: 'col-6',
                placeholder: '例） 山田　Yamada'
              }
            ]
          }, {
            legend: '同伴者3',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '名',
                model: 'otherPeople.person3.firstname',
                visible: function (model) {
                  return model.numAccompany > 2
                },
                styleClasses: 'col-6',
                placeholder: '例） 太郎　Taro'
              }, {
                type: 'input',
                inputType: 'text',
                label: '姓',
                model: 'otherPeople.person3.lastname',
                visible: function (model) {
                  return model.numAccompany > 2
                },
                styleClasses: 'col-6',
                placeholder: '例） 山田　Yamada'
              }
            ]
          }, {
            legend: '同伴者4',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '名',
                model: 'otherPeople.person4.firstname',
                visible: function (model) {
                  return model.numAccompany > 3
                },
                styleClasses: 'col-6',
                placeholder: '例） 太郎　Taro'
              }, {
                type: 'input',
                inputType: 'text',
                label: '姓',
                model: 'otherPeople.person4.lastname',
                visible: function (model) {
                  return model.numAccompany > 3
                },
                styleClasses: 'col-6',
                placeholder: '例） 山田　Yamada'
              }
            ]
          }, {
            legend: '同伴者5',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '名',
                model: 'otherPeople.person5.firstname',
                visible: function (model) {
                  return model.numAccompany > 4
                },
                styleClasses: 'col-6',
                placeholder: '例） 太郎　Taro'
              }, {
                type: 'input',
                inputType: 'text',
                label: '姓',
                model: 'otherPeople.person5.lastname',
                visible: function (model) {
                  return model.numAccompany > 4
                },
                styleClasses: 'col-6',
                placeholder: '例） 山田　Yamada'
              }
            ]
          }, {
            legend: '同伴者6',
            fields: [
              {
                type: 'input',
                inputType: 'text',
                label: '名',
                model: 'otherPeople.person6.firstname',
                visible: function (model) {
                  return model.numAccompany > 5
                },
                styleClasses: 'col-6',
                placeholder: '例） 太郎　Taro'
              }, {
                type: 'input',
                inputType: 'text',
                label: '姓',
                model: 'otherPeople.person6.lastname',
                visible: function (model) {
                  return model.numAccompany > 5
                },
                styleClasses: 'col-6',
                placeholder: '例） 山田　Yamada'
              }
            ]
          }
        ]
      }
      self.formOptions = {
        validateAfterLoad: false,
        validateAfterChanged: true,
        validateAsync: true,
        validateDebounceTime: 500
      }
    },

    fillQRCode() {
      var self = this
      return self.$store.state.userData
    },

    async check () {
      var self = this
      self.errors.bureauName1 = false;
      self.errors.departmentName1 = false;
      self.errors.departmentName2 = false;
      if (self.officeSectionName) {
        if (self.bureauName1 == null || self.bureauName1.trim() == '') {
          self.errors.bureauName1 = true;
        }
        if (self.bureauName1 != '' && self.departmentNameSelect1.length == 0) {
          self.errors.departmentName1 = false;
        }

        if (self.bureauName2 != '' && self.departmentNameSelect2.length == 0) {
          self.errors.departmentName2 = false;
        }
      }

      if (self.isVisitPlaceOther && (self.visitPlaceOther.trim() == '' || self.visitPlaceOther == null)) {
        self.errors.visitPlaceOther = true;
      } else {
        self.errors.visitPlaceOther = false;
      }

      if ( !self.officeSectionName && !self.destinationCheck1 && !self.destinationCheck2 && !self.destinationCheck3 && !self.destinationCheck4 && !self.destinationCheck5 && !self.destinationCheck6 &&
        !self.isVisitPlaceOther) {
        self.errors.atLeastVisitPlace = true;
      } else {
        self.errors.atLeastVisitPlace = false;
      }

      if (self.$refs.form && self.$refs.form.errors) {
        await self.$refs.form.validate()
        let errorElements = document.getElementsByClassName('error')
        if (errorElements.length || self.errors.bureauName1 || self.errors.departmentName1 || self.errors.departmentName2 || self.errors.visitPlaceOther) {
          errorElements[0].scrollIntoView({behavior: 'smooth'})
        } else {
          self.$emit('goToConfirm', 'Confirm')
          self.$emit('getModel', self.model)
        }
      }
    },

    fillDB() {
      var self = this
      let firstname = self.model.demanderName.firstname
      let lastname = self.model.demanderName.lastname
      let firstname_kata = self.model.demanderNameKata.firstname
      let lastname_kata = self.model.demanderNameKata.lastname

      if (firstname !== '' && lastname !== '' && firstname_kata !== '' && lastname_kata !== '') {
        var apiURL = 'http://swt033-fcr173-nathan-nhan:8888/search_visitor.php?firstname='+ firstname + '&lastname='+ lastname + '&firstname_kata='+ firstname_kata + '&lastname_kata='+ lastname_kata
        return self.$http
          .get(apiURL)
          .then( response => {
            var dataStr = response.body.user_data
            if (dataStr) {
              var dataObj = JSON.parse(dataStr)

              self.fillData(dataObj)
              // console.log(dataObj)
              self.isEditing = true
            }
          })
      }
    },
    fillData(obj) {
      var self = this

      // Build checklist for destination visit
      var destination = obj.create_re_counter ? obj.create_re_counter.split('/') : ''
      var listDestinations = self.$store.state.destinationChecks
      for (let i = 1; i<= 6; i++) {
        self['destinationCheck' + i] = destination.includes(listDestinations['destinationCheck' + i])
      }
      var otherOffice = [];
      destination.map( (item) => {
        if (item.indexOf('その他 ') > -1) {
          self.isVisitPlaceOther = true
          self.visitPlaceOther = item.split('その他 ')[1]
        } else {
          if (
            item != listDestinations.destinationCheck1 &&
            item != listDestinations.destinationCheck2 &&
            item != listDestinations.destinationCheck3 &&
            item != listDestinations.destinationCheck4 &&
            item != listDestinations.destinationCheck5 &&
            item != listDestinations.destinationCheck6
          ) {
            otherOffice.push(item)
          }
          self.isVisitPlaceOther = false
          self.visitPlaceOther = ''
        }
      })

      // Build selection for other office option
      if (otherOffice.length) {
        for (let i = 0; i < otherOffice.length; i++) {
          var office1 = otherOffice[0]
          var office2 = otherOffice[1]
          var station1 = office1.split(' ')[0]
          var department1 = office1.split(' ')[1]
          self.bureauName1 = station1
          if (department1) {
            setTimeout( function () {
              self.departmentName1 = department1
            }, 500)
          }
          if (office2) {
            var station2 = office2.split(' ')[0]
            var department2 = office2.split(' ')[1]
            self.bureauName2 = station2
            if (department2) {
              setTimeout( function () {
                self.departmentName2 = department2
              }, 500)
            }
          }
        }
      } else {
        self.bureauName1 = ''
        self.bureauName2 = ''
        self.departmentName1 = ''
        self.departmentName2 = ''
        self.officeSectionName = false
      }

      let num_accompany = Object.keys(obj.people).length

      for (let i = 1; i <= num_accompany; i++) {
        self.model.otherPeople['people' + i] = {
          'lastname':  obj.people['people' + i].lastname,
          'firstname': obj.people['people' + i].firstname
        }
      }

      self.model.moveDay.year = parseInt(obj.move_date.substr(0, 4))
      self.model.moveDay.month = parseInt(obj.move_date.substr(4, 2))
      self.model.moveDay.day = parseInt(obj.move_date.substr(6, 2))
      self.model.createDemanDate = obj.create_deman_date
      self.model.demanderName = {
        lastname: obj.demander_name.lastname,
        firstname: obj.demander_name.firstname
      }
      self.model.demanderNameKata = {
        lastname: obj.demander_name_kata.lastname,
        firstname: obj.demander_name_kata.firstname
      }
      self.model.companyName = obj.company_name
      self.model.createPhoneNumber = obj.create_phone_number
      self.model.tempReEntry = obj.temp_re_entry
      self.model.createReCounter = destination
      self.model.numAccompany = num_accompany
    },

    /** Create data for current year and next year */
    createYearData: function() {
      var self = this;
      self.thisYear = new Date().getFullYear();
      self.nextYear = new Date().getFullYear() + 1;
      self.year = self.thisYear;
      self.month = new Date().getMonth() < 9 ? '0' + parseInt(new Date().getMonth() + 1) : new Date().getMonth() + 1;
      self.day = new Date().getDate() < 10 ? '0' + new Date().getDate() : new Date().getDate();
    },
    findWorkingDay: function() {
      var self = this;
      var tempMonth = self.month < 10 ? '0' + self.month : self.month;
      var tempDay = self.day < 10 ? '0' + self.day : self.day;
      var stringDate = self.year + tempMonth + tempDay;
      if (self.daysOff.indexOf(stringDate) != -1) {
        var tomorrow = new Date(self.year, Number(self.month) - 1, self.day);
        tomorrow.setDate(tomorrow.getDate() + 1);
        self.year = tomorrow.getFullYear();
        self.month = tomorrow.getMonth() + 1;
        self.day = tomorrow.getDate();
        var tempMonth2 = self.month < 10 ? '0' + self.month : self.month;
        var tempDay2 = self.day < 10 ? '0' + self.day : self.day;
        var stringDate2 = self.year + tempMonth2 + tempDay2;
        if (self.daysOff.indexOf(stringDate2) != -1) {
          self.findWorkingDay();
        }
      }
    },
    /** Make list of day according to current selected month and year
     * @param {string} type - change year or month
     */
    makeListOfMonthDay: function(type) {
      var self = this;
      self.listOfDay = [];
      self.listOfMonth = [];
      var numberOfDays = self.daysInMonth(self.month, self.year);

      for (var i = 1; i <= numberOfDays; i++) {
        // create date string
        var tempMonth = self.month < 10 ? '0' + self.month : self.month;
        var tempDay = i < 10 ? '0' + i : i;
        var stringDate = self.year + tempMonth + tempDay;
        if (self.daysOff.indexOf(stringDate) == -1) {
          self.listOfDay.push(i);
        }
      }
      for (var j = 1; j <= 12; j++) {
        self.listOfMonth.push(j);
      }

      if (
        self.month == new Date().getMonth() + 1 &&
        self.year == new Date().getFullYear()
      ) {
        self.listOfDay = self.listOfDay.filter(function(item) {
          return item >= new Date().getDate();
        });
      }
      if (type == 'month' && numberOfDays < self.day) {
        self.day = numberOfDays;
      }

      if (self.year == new Date().getFullYear()) {
        self.listOfMonth = self.listOfMonth.filter(function(item) {
          return item >= new Date().getMonth() + 1;
        });
      }
    },
    /**
     * Count How many days in current selected month and year
     * @param {number} month - month
     * @param {number} year - year
     */
    daysInMonth: function(month, year) {
      return new Date(year, month, 0).getDate();
    },

    getCSVData() {
      var self = this
      // var tempDivision = []

      // Get location
      self.$http
        .get('http://swt033-fcr173-nathan-nhan:8888/get_csv_data.php?f=division_master.csv')
        .then(response => {
          var divisions = []
          const rows = response.body
          for (let i = 0; i < rows.length; i += 4) {
            var chunk = rows.slice(i, i + 4);
            divisions.push(chunk);
          }
          self.initSelect(divisions)
        })
        .catch(error => {
          console.log(error)
        })

      // Get list days off
      self.$http
        .get('http://swt033-fcr173-nathan-nhan:8888/get_csv_data.php?f=days_off.csv')
        .then( response => {
          self.daysOff = response.body;
          self.makeListOfMonthDay();
          self.findWorkingDay();
        })
        .catch(error => {
          console.log(error)
        })
    },

    /**
     * Init data from csv to Bureau Name selection
     * @param {string} data - csv content
     */
    initSelect: function(data) {
      var self = this;
      var length = data.length;
      /** Find string in exist in object of array */
      var findIndex = function(arr, compare) {
        var found = false;
        for (var i = 0; i < arr.length; i++) {
          if (arr[i].name == compare) {
            found = true;
            break;
          }
        }
        return found;
      };

      for (var i = 1; i < length; i++) {
        if (data[i][0] && data[i].length == 4) {
          if (!findIndex(self.bureauNameSelect, data[i][0].trim())) {
            self.bureauNameSelect.push({
              sortName: data[i][2].trim(),
              name: data[i][0].trim()
            });
          }
          var department = data[i][1].trim();
          if (department != '') {
            self.departmentNameSelect.push({
              sortName: data[i][3].trim(),
              parent: data[i][2].trim(),
              name: data[i][1].trim()
            });
          }
        }
      }

      self.changeBureauName(1)
      self.changeBureauName(2)
    },

    formatCSVOutput: function (item) {
      var jp = item.split('<br>')[0]
      return jp
    },

    /**
     * When user select Bureau Name -> change Department Name options
     * @param {string} key - key of variable that we will change department
     */
    changeBureauName: function(key) {
      var self = this;
      self['departmentNameSelect' + key] = [];
      for (var x in self.departmentNameSelect) {
        if (self.departmentNameSelect[x].parent == self['bureauName' + key]) {
          self['departmentNameSelect' + key].push({
            name: self.departmentNameSelect[x].name,
            sortName: self.departmentNameSelect[x].sortName
          });
        }
      }
      self['departmentName' + key] = '';
    },

    removeValid: function(field) {
      var self = this;
      self.errors[field] = false;
    },

    validAfterSelectDivision: function() {
      var self = this;
      if (
        self.bureauName1 == self.bureauName2 &&
        self.departmentName1 == self.departmentName2 &&
        self.bureauName1 != '' &&
        self.bureauName1 != null &&
        self.departmentName1 != '' &&
        self.departmentName1 != null &&
        self.departmentName2 != '' &&
        self.departmentName2 != null
      ) {
        self.errors.sameBureauDivisionName = true;
      } else {
        self.errors.sameBureauDivisionName = false;
      }
    },

    removeSpecialLetter: function(str) {
      if (str != '') {
        str = str.trim();
        str = str.replace(/[^\w\s]/gi, '');
      }

      return str;
    },

    updateReCounter(field) {
      var self = this;
      if (field)
        self.removeValid(field)

      var destinationChecks = self.$store.state.destinationChecks
      var bureauName1 = '';
      var bureauName2 = '';
      var departmentName1 = '';
      var departmentName2 = '';
      var strCheckboxes = '';
      var strSelect = '';
      var tempArr = [];

      if (self.bureauName1 !== '' || self.bureauName2 !== '')
        self.officeSectionName = true

      if (self.destinationCheck1) {
        tempArr.push(destinationChecks.destinationCheck1);
      }
      if (self.destinationCheck2) {
        tempArr.push(destinationChecks.destinationCheck2);
      }
      if (self.destinationCheck3) {
        tempArr.push(destinationChecks.destinationCheck3);
      }
      if (self.destinationCheck4) {
        tempArr.push(destinationChecks.destinationCheck4);
      }
      if (self.destinationCheck5) {
        tempArr.push(destinationChecks.destinationCheck5);
      }
      if (self.destinationCheck6) {
        tempArr.push(destinationChecks.destinationCheck6);
      }

      if (self.officeSectionName) {
        bureauName1 = self.bureauName1;
        bureauName2 = self.bureauName2;
        departmentName1 = self.departmentName1;
        departmentName2 = self.departmentName2;

        if (bureauName1 !== '') {
          strSelect += bureauName1;
          if (departmentName1) {
            strSelect += ' ' + departmentName1;
          }
        }
        if (bureauName2 !== '') {
          strSelect += '/' + bureauName2;
          if (departmentName2) {
            strSelect += ' ' + departmentName2;
          }
        }
        if (strSelect !== '')
          tempArr.push(strSelect)
      }

      if (
        self.isVisitPlaceOther &&
        self.visitPlaceOther != null &&
        self.visitPlaceOther != ''
      ) {
        let other = self.removeSpecialLetter(self.visitPlaceOther);
        strCheckboxes = 'その他 ' + other;
        tempArr.push(strCheckboxes)
      }

      if (tempArr.length !== 0)
        self.model.createReCounter = tempArr
    },
    updateNumAccompany(num) {
      var self = this
      for (let i = num; i < 6; i++) {
        self.model.otherPeople['people' + parseInt(i + 1)].lastname = ''
        self.model.otherPeople['people' + parseInt(i + 1)].firstname = ''
      }
    }
  },

  computed: {
  },

  mounted () {
    var self = this
    self.init()
    self.createYearData()
    self.getCSVData()

    self.updateReCounter()
    self.validAfterSelectDivision()
  }
}
</script>

<style lang="sass" scoped>
.section-category
  text-align: left
</style>