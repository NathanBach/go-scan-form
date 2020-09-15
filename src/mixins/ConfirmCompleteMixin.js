export const ConfirmCompleteMixin = {
  methods: {
    updatePDF(callback) {
      const pages = this.pdfDoc.getPages();

      const firstPage = pages[0];
      const { height } = firstPage.getSize()
      var text = `
        Name: 
        ${ this.model.demanderName.lastname }, ${ this.model.demanderName.firstname }
        ${ this.model.demanderNameKata.lastname }, ${ this.model.demanderNameKata.firstname } \n
        Date of Visit: 
        ${ this.model.moveDay.year }年, ${ this.model.moveDay.month }月, ${ this.model.moveDay.day }日\n
        Company Name: 
        ${!this.individuals ? `${ this.model.companyName }` : ""}\n
        Phone Number: 
        ${!this.noPhoneNumber ? `${ this.model.createPhoneNumber }` : ""}\n
        Accompanying Visitors: 
        ${ Number(this.model.numAccompany) > 0 ? `${ this.model.otherPeople.people1.lastname }, ${ this.model.otherPeople.people1.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 1 ? `${ this.model.otherPeople.people2.lastname }, ${ this.model.otherPeople.people2.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 2 ? `${ this.model.otherPeople.people3.lastname }, ${ this.model.otherPeople.people3.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 3 ? `${ this.model.otherPeople.people4.lastname }, ${ this.model.otherPeople.people4.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 4 ? `${ this.model.otherPeople.people5.lastname }, ${ this.model.otherPeople.people5.firstname }` : " "}
        ${ Number(this.model.numAccompany) > 5 ? `${ this.model.otherPeople.people6.lastname }, ${ this.model.otherPeople.people6.firstname }` : " "}
        Destinations: \b
        ${ this.model.createReCounter[0] ? `${ this.model.createReCounter[0]}` : "" }
        ${ this.model.createReCounter[1] ? `${ this.model.createReCounter[1]}` : "" }
        ${ this.model.createReCounter[2] ? `${ this.model.createReCounter[2]}` : "" }
        ${ this.model.createReCounter[3] ? `${ this.model.createReCounter[3]}` : "" }
        ${ this.model.createReCounter[4] ? `${ this.model.createReCounter[4]}` : "" }
        ${ this.model.createReCounter[5] ? `${ this.model.createReCounter[5]}` : "" }
        Other department(s) （selection）:
        ${this.bureauName1.length ? ` ${this.findFullNameSelect(this.bureauName1, 1)}, ${this.findFullNameSelect(this.departmentName1, 2)}` : ""}
        ${this.bureauName2.length ? ` ${this.findFullNameSelect(this.bureauName2, 1)}, ${this.findFullNameSelect(this.departmentName2, 2)}` : ""}
        Re-Entry: \b
        ${this.model.tempReEntry == '1' ? "Yes" : "No"}
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
        printJS({printable: base64, type: 'pdf', base64: true});
      })
    },
  }
}