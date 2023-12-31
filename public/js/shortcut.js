// start pagination table

const tables = document.querySelectorAll(".pagination-table");
const dictionary = {
    english : {
        "next": "Next",
        "previous": "Previous",
        "numberRerecordInSlide": "Number Rerecord In Slide",
        "from": "From",
    },
    arabic: {
        "next": "التالي",
        "previous": "السابق",
        "numberRerecordInSlide": "عدد الصفوف",
        "from": "من",
    }
}

async function fetchData() {
    const response = await fetch("http://precatalog.local/ajax/getAppLanguage", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    });
    const data = await response.json();
    localStorage.setItem("language", data.language.toLowerCase());

    return JSON.stringify(data);
}
fetchData();
function removeAllChildNodes(parent) {
    while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
    }
}

class PaginationTable {

    constructor(table) {
        this.table = table;
        this.tBody = this.getTBody();
        this.currentRow = 0;
        this.currentSlidePos = 1;
        this.ulBtns = null;
        this.rows = this.getRowsAsArray();
        this.numberRowsInSlide = localStorage.getItem("numberRowsInSlide") ? localStorage.getItem("numberRowsInSlide") : 4;
        this.countSlides = Math.ceil(this.rows.length / this.numberRowsInSlide);
        this.prevBtn = null;
        this.nextBtn = null;
        this.currentSlideDiv = null;
        this.paginationSection = null;
        this.isUpperBar = this.table.classList.contains("upper");
        this.fromDiv = null;
    }
    setNumberRowsInSlide() {
        if (localStorage.getItem("numberRowsInSlide")) {
            this.numberRowsInSlide = localStorage.getItem("numberRowsInSlide");
        } else {
            this.numberRowsInSlide = 4;
            localStorage.setItem("numberRowsInSlide", '4');
        }
    }
    getNumberRowsInSlide () {
        return localStorage.getItem("numberRowsInSlide");
    }
    getRowsAsHtmlObj() {
        return this.tBody.querySelectorAll("tr");
    }
    getRowsAsArray() {
        let trs = [];
        let rows = this.getRowsAsHtmlObj()
        for (const rowsKey in rows) {
            if (rows.hasOwnProperty(rowsKey)) {
                trs.push(rows[rowsKey]);
            }
        }
        return trs;
    }
    getTBody() {
        return this.table.querySelector("tbody");
    }
    resitALl (e=null) {
        this.numberRowsInSlide = Number(e.target.value)
        this.currentRow = 0;
        this.currentSlidePos = 1;
        this.countSlides = Math.ceil(this.rows.length / this.numberRowsInSlide);
    }
    whenChangeShowRowsValue(e) {
        localStorage.setItem("numberRowsInSlide", e.target.value);
        this.resitALl(e)
        this.fromDiv.textContent = '';
        this.fromDiv.textContent = this.countSlides;
        this.shuffleButtons();
        this.showSlide()
    }
    createPaginationBar(table) {

        let barPaginationDiv = document.createElement("div");
        barPaginationDiv.classList.add("bar-pagination");

        if (table.classList.contains("bg-dark-subtle")) {
            barPaginationDiv.classList.add("bg-dark-subtle");
        }

        // Create statistics div
        let statisticsDiv = document.createElement("div");
        statisticsDiv.classList.add("statistics");
        let numberSlideDiv = document.createElement("number-slide");
        let label = document.createElement("label");

        label.textContent = dictionary[localStorage.getItem("language")]["numberRerecordInSlide"];
        numberSlideDiv.appendChild(label);

        // Create select
        let select = document.createElement("select");
        select.addEventListener("change", (e) => {this.whenChangeShowRowsValue(e)});


        // Create Options
        for (let i = 1; i <= 5; i++) {
            let opt = document.createElement("option");
            opt.value = (i * 2).toString();

            if ( (i * 2).toString() === localStorage.getItem("numberRowsInSlide")) {
                opt.selected = true;
            }

            opt.textContent = (i * 2).toString();
            select.appendChild(opt);
        }

        numberSlideDiv.appendChild(select);
        statisticsDiv.appendChild(numberSlideDiv);
        barPaginationDiv.appendChild(statisticsDiv);

        // create counter hint
        let counterDiv = document.createElement("div");
        counterDiv.classList.add("counter");
        // create number current slide div
        let currentSlideDiv = document.createElement("div");

        currentSlideDiv.textContent = this.currentSlidePos;
        this.currentSlideDiv = currentSlideDiv;
        counterDiv.appendChild(currentSlideDiv);
        // create from span
        let fromSpan = document.createElement("span");

        fromSpan.textContent = dictionary[localStorage.getItem("language")]["from"];
        counterDiv.appendChild(fromSpan)
        // create from div
        let fromDiv = document.createElement("div");
        fromDiv.textContent = this.countSlides.toString();
        this.fromDiv = fromDiv;
        counterDiv.appendChild(fromDiv);

        statisticsDiv.appendChild(counterDiv);

        // start buttons
        let buttonsDiv = document.createElement("div");
        buttonsDiv.classList.add("buttons");

        // create previous button
        let previousBtn = document.createElement("button");
        previousBtn.classList.add("previous");
        previousBtn.classList.add("main-btn");
        previousBtn.textContent = dictionary[localStorage.getItem("language")]["previous"]
        buttonsDiv.appendChild(previousBtn);
        this.prevBtn  = previousBtn;

        // create next button
        let nextBtn = document.createElement("button");
        nextBtn.classList.add("next");
        nextBtn.classList.add("main-btn");
        nextBtn.classList.add("active");
        nextBtn.textContent = dictionary[localStorage.getItem("language")]["next"]
        this.nextBtn = nextBtn;

        // create ul
        let ul = document.createElement("ul");
        this.ulBtns = ul;
        buttonsDiv.appendChild(ul)
        this.shuffleButtons();


        buttonsDiv.appendChild(nextBtn);

        barPaginationDiv.appendChild(buttonsDiv);
        if (this.isUpperBar) {
            barPaginationDiv.classList.add("upper")
        }
        return barPaginationDiv;

    }
    createNodesNumber(content, count=null) {
        let li = document.createElement("li");
        if (count != null) {
            li.setAttribute("count", count);
            li.addEventListener("click", () => {
                if (this.currentSlidePos > count) {
                    this.currentRow = (count * this.numberRowsInSlide) -this.numberRowsInSlide;
                } else if(this.currentSlidePos < count) {
                    this.currentRow += this.numberRowsInSlide;
                }
                this.currentSlidePos = count;
                li.classList.add("current-slide");
                this.showSlide()
                this.shuffleButtons();
            });
        } else {
            li.classList.add("pointer-e-non");
        }
        // Check if this an active slide
        if (count === this.currentSlidePos) {
            li.classList.add("current-slide");
        }

        li.textContent = content;
        return li;
    }
    checkActivationPrevNextBtn() {
        if (this.countSlides === 1) {
            this.nextBtn.classList.remove("active")
            this.prevBtn.classList.remove("active")
            return;
        }
        if (this.currentSlidePos === this.countSlides) {
            this.nextBtn.classList.remove("active")
            this.prevBtn.classList.add("active")
        }
        if (this.currentSlidePos === 1) {
            this.prevBtn.classList.remove("active")
            this.nextBtn.classList.add("active")
        } else {
            this.prevBtn.classList.add("active")
        }
    }
    shuffleButtons() {
        removeAllChildNodes(this.ulBtns);

        if (this.countSlides <= 6) {
            for (let i = 1; i <= this.countSlides; i++) {
                let li = this.createNodesNumber(i, i);
                this.ulBtns.appendChild(li);
            }
            this.checkActivationPrevNextBtn();
            return true;
        }

        // If current slide not override half slides I will create nodes (1 to 6) (...) (lasNode)
        let halfSlidesCount = Math.floor(this.countSlides / 2);
        if (this.currentSlidePos < halfSlidesCount && this.currentSlidePos <= 6) {
            for(let i = 1; i < 6; i++) {
                let li = this.createNodesNumber(i, i);
                this.ulBtns.appendChild(li);
            }
            // Create Dot node
            this.ulBtns.appendChild(this.createNodesNumber("..."));
            // Create Last Node
            this.ulBtns.appendChild(this.createNodesNumber(this.countSlides, this.countSlides));

            this.checkActivationPrevNextBtn();
        }

        // If current slide not override half slides I will create nodes (1) (...) (lasNode - 6 to last node)
        if (this.currentSlidePos <= this.countSlides && this.currentSlidePos >= this.countSlides - 6) {
            this.ulBtns.appendChild(this.createNodesNumber(1, 1));
            // Create Dot node
            this.ulBtns.appendChild(this.createNodesNumber("..."));
            for(let i = this.countSlides - 5; i <= this.countSlides; i++) {
                let li = this.createNodesNumber(i, i);
                this.ulBtns.appendChild(li);
            }
            this.checkActivationPrevNextBtn();
        }

        // If current slide in medium
        if (this.currentSlidePos > 6 && this.currentSlidePos < this.countSlides - 6) {
            this.ulBtns.appendChild(this.createNodesNumber(1, 1));
            // Create Dot node
            this.ulBtns.appendChild(this.createNodesNumber("..."));

            for(let i = this.currentSlidePos; i < this.currentSlidePos + 4; i++) {
                this.ulBtns.appendChild(this.createNodesNumber(i, i));
            }
            this.ulBtns.appendChild(this.createNodesNumber("..."));
            this.ulBtns.appendChild(this.createNodesNumber(this.countSlides, this.countSlides));
            this.checkActivationPrevNextBtn();
        }

    }
    appendPaginationSectionInTable(table) {
        this.paginationSection = this.createPaginationBar(table);

        // remove all previous pagination section
        if (this.paginationSection != null) {
            let bars = this.table.parentElement.querySelectorAll(".bar-pagination");
            bars.forEach((bar) => {
                bar.remove()
            });
        }
        if (this.isUpperBar) {
            this.table.parentElement.prepend(this.paginationSection);
        }  else {
            this.table.parentElement.appendChild(this.paginationSection);
        }

    }
    changeSlideNumberInStatisticsSection() {
        this.currentSlideDiv.textContent = '';
        this.currentSlideDiv.textContent = this.currentSlidePos;
    }
    showSlide() {
        removeAllChildNodes(this.tBody);
        this.rows.slice(this.currentRow, this.currentRow + this.numberRowsInSlide).forEach((row) => {
            this.tBody.appendChild(row);
        });
        this.changeSlideNumberInStatisticsSection()
        this.shuffleButtons()
    }
    pagination(table) {
        this.appendPaginationSectionInTable(table);
        this.showSlide();
        this.nextBtn.addEventListener("click", () => {
            this.currentSlidePos++;
            this.currentRow += this.numberRowsInSlide;
            this.showSlide();
        });
        this.prevBtn.addEventListener("click", () => {
            this.currentSlidePos--;
            this.currentRow -= this.numberRowsInSlide;
            this.showSlide();
        });
    }
}
tables.forEach(table => {
    let pagination = new PaginationTable(table);
    pagination.pagination(table)
});

// End Pagination table


// Start Show Password
let showPasswordInputs = document.querySelectorAll('[show-password]');
showPasswordInputs.forEach(showBtn => {

    let parent = showBtn.parentElement;
    parent.style.position = "relative";


    showBtn.addEventListener("click", (event) => {
        event.preventDefault();
        let input = showBtn.parentElement.querySelector("input");
        let value = input.value.toString();


        input.value = '';

        if (showBtn.getAttribute("show-password") === "false") {
            input.type = 'text';
            input.value = value.toString();
            showBtn.setAttribute("show-password", "true");
        } else  {
            input.type = 'password';
            input.value = value.toString();
            showBtn.setAttribute("show-password", "false");
        }
   });

});
// End Show Password



// Start Validation Between
let betweenValidationInputs = document.querySelectorAll('[between]');

betweenValidationInputs.forEach(betweenInput => {

   let params = betweenInput.getAttribute("between");

    let pattern = /\d+/g;

    let values = params.match(pattern);

    let min = values[0];
    let max = values[1];

    betweenInput.addEventListener("keyup", () => {
        let inputType = betweenInput.type;
        let condition = null;

        if (inputType === 'number') {
            condition = Number(betweenInput.value) < Number(min) || Number(betweenInput.value) > Number(max);
        } else {
            condition = betweenInput.value.length < Number(min) || betweenInput.value.length > Number(max);
        }

       if (condition) {
           let invalidFeedBack = betweenInput.parentElement.querySelector(".invalid-feedback");
           let validFeedBack = betweenInput.parentElement.querySelector(".valid-feedback");
            invalidFeedBack.classList.add("active");
           validFeedBack.classList.remove("active");
       } else {
           let invalidFeedBack = betweenInput.parentElement.querySelector(".invalid-feedback");
           let validFeedBack = betweenInput.parentElement.querySelector(".valid-feedback");
           invalidFeedBack.classList.remove("active");
           validFeedBack.classList.add("active");
       }
    });

});
// End Validation Between


// Start Validation Email
let emailInputs = document.querySelectorAll("[email-input]");
emailInputs.forEach(emailInput => {
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    emailInput.addEventListener("keyup", () => {
        let validFeedBack = emailInput.parentElement.querySelector(".valid-feedback");
        let invalidFeedBack = emailInput.parentElement.querySelector(".invalid-feedback");
       if (emailPattern.test(emailInput.value)) {
           invalidFeedBack.classList.remove("active");
           validFeedBack.classList.add("active");
       } else {
           invalidFeedBack.classList.add("active");
           validFeedBack.classList.remove("active");
       }
    });


});
// End Validation Email
// Start required to be input
document.querySelectorAll(".input[required]").forEach(input => {
    let star = document.createElement('i');
    star.className = 'fa-solid fa-asterisk asterisk-required';
    input.appendChild(star);
});
// End required to be input