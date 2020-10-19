window.log = console.log;

class FestivalApp {
    constructor(){

        this.$content = $("#content");
        this.$paging = $("#paging");
        this.$modal = $('#modal');
        this.xml;
        this.datas;
        this.slide_idx = 0;
        this.isSliding = false;
        this.init();
    }

    async init(){
        this.xml = await this.readFestivals();
        this.generateDatas();
        this.render();
        this.addEvent();
    }

    generateDatas(){
        this.datas = JSON.parse(this.xml).festivals;   
    }

    readFestivals(){
        return new Promise(( res,rej )=>{
            $.ajax({
                method : "POST",
                url : "/api/get/festival",
                success : e => { res(e) }  
            }); 
        });
    }

    render(){
        let qs = location.search.substring(1, location.search.length);
        let qsObj = {};
        qs.split("&").forEach(x=>{
            let key = x.split("=")[0];
            let value = x.split("=")[1];
            qsObj[key] = value;
        });
        
        let page = qsObj.page * 1;
        page = isNaN(page) || !page || page < 1 ? 1 : page;
        
        let type = qsObj.searchType;
        type = ["album","list"].includes(type) ? type : "album";
        
        const PAGE_CNT = 11;
        const PAGE_SCNT = 5;
        let totalPage = Math.ceil(this.datas.length / PAGE_CNT);
        let currentChapter = Math.ceil(page / PAGE_SCNT);

        let start = (currentChapter - 1) * PAGE_SCNT + 1;
        if(start < 1) start = 1;
        let end = currentChapter * PAGE_SCNT;
        if(end > totalPage) end = totalPage;
        
        let prev = start - 1 > 1;
        let next = end + 1 < totalPage;
        
        let si = (page - 1) * PAGE_CNT;
        let si_e = si + PAGE_CNT;
        let arr = this.datas.slice( si , si_e );
        let html = "";
        for(let i = start; i <= end; i++) html += `<a class="page_item page_${ i === page ? "active" : "normal" }" href="?searchType=${type}&page=${i}">${i}</a>`;
        html = `<a class="page_item page_${ prev ? "active" : "normal" }" href="?searchType=${type}&page=${ prev ? (currentChapter - 2) * PAGE_CNT + 1 : 1  }"><i class="fa fa-angle-left"></i></a>
                ${html}
                <a class="page_item page_${ next ? "active" : "normal" }" href="?searchType=${type}&page=${ next ? currentChapter * PAGE_CNT : totalPage  }"><i class="fa fa-angle-right"></i></a>`;
        this.$paging.html(html);
        
        this.drawAlbum(arr);
        log(arr);
    }

    drawAlbum(arr){

        arr.map( festival => {

            
            
        });
        
        this.$content.find("#last_festival").on("click", this.itemClickEventHandler);

    }

    loadImage(src){
        return new Promise(( res , rej )=>{

            let img = new Image();
            img.src = src;
            img.addEventListener("load",(e)=>{
                res(img);
            });

            img.addEventListener("error",(e)=>{
                img.src = "/imgs/img_no.png";
            });

        });
    }

    drawList(arr){
        arr.forEach(festival=>{
            
            let tr = document.createElement("tr");
            tr.dataset.sn = festival.sn;
            tr.innerHTML = `
                <td>${ festival.sn }</td>
                <td>${ festival.nm }</td>
                <td>${ festival.dt }</td>
                <td>${ festival.area }</td>
            `;

            document.querySelector("#list-tbody").appendChild(tr);
            tr.addEventListener("click", this.itemClickEventHandler);
        });
    }

    addEvent(){
        this.$content.on("click", ".festival_item", this.itemClickEventHandler);

    }

    itemClickEventHandler = e => {

        let sn = e.currentTarget.dataset.sn;
        let festival = this.datas.find(x=> x.sn === sn);
        log(festival);
        let imgLen = festival.imgs.length;

        this.$modal.attr("title", festival.nm );
        let option = {
            show : { effect : "fade", duration : 200 },
            hide : { effect : "fade", duration : 200 },
            width : 800,
            dialog : true
        };
        
        let buttons = '';
        for(let i = 1; i <= festival.imgs.length; i++) buttons += `<button class="slide_btn">${i}</button>`;

        this.$modal.html(
        `<div class="row mt-3">
            <div class="col-6">
                <img src="${ festival.imagePath + "/" + festival.imgs[0] }" alt="asdf" title="asdf" class="img-parent-cover">
            </div>

            <div class="col-6">
                <h4>${festival.name}</h4>
                <p>지역 : ${festival.area}</p>
                <p>장소 : ${festival.location}</p>
                <p>기간 : ${festival.dt}</p>
                <p>${festival.cn}</p>
            </div>
        </div>
        <div class="row mt-4">
            <div id="slider">
                ${ festival.imgs.map( img => `<img src="${ festival.imagePath + "/" + img }" title="asdf" alt="asdf">` ).join('') }
            </div>
        </div>
        <div class="row mt-3 slider_page">
            <button class="slide_btn" data-dir="-1" disabled>이전</button>
            ${buttons}
            <button class="slide_btn" data-dir="1">다음</button>
        </div>`);

        this.slide_idx = 0;
        this.isSliding = false;

        this.$modal.dialog(option);
        this.$modal.find("#slider > img").css({ opacity : 0 , zIndex : 1 }).eq(this.slide_idx).css({ opacity : 1 , zIndex : 2 });
        this.$modal.find(".slide_btn").eq(1).addClass("slide_now");
        this.$modal.find(".slide_btn").on("click",(e)=>{
            let dir = e.currentTarget.dataset.dir * 1;
            if(!dir) return;
            if(this.isSliding) return;
            this.isSliding  = true;
            this.slide_idx += dir;
            if(this.slide_idx === 0) this.$modal.find(".slide_btn").eq(0).attr("disabled" , "disabled");
            else this.$modal.find(".slide_btn").eq(0).removeAttr( "disabled");
            if(this.slide_idx >= imgLen - 1) this.$modal.find(".slide_btn").eq(imgLen + 1).attr("disabled" , "disabled");
            else this.$modal.find(".slide_btn").eq(imgLen + 1).removeAttr("disabled");

            this.$modal.find("#slider > img").css({zIndex : 1 , opacity : 0 }).eq(this.slide_idx).css({zIndex : 2}).animate({ opacity : 1 }, (end)=>{
                this.isSliding = false;
            });
            this.$modal.find(".slide_btn").removeClass("slide_now").eq(this.slide_idx + 1).addClass("slide_now");
        });
        
        this.$modal.find("img").on("error", e => {
            $(e.target).attr("src", 'imgs/img_no.png');
        });
    }
}

window.addEventListener("load",(e)=>{
    window.festivalApp = new FestivalApp();
});
