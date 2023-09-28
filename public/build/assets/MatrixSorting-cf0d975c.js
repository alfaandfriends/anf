import{c as o,d as a,b as p,w as h,F as _,h as w,o as r,k as m,f as v,l as y,t as c,m as b,j as d}from"./app-7052c322.js";import{B as g}from"./Button-5191ca95.js";import"./_plugin-vue_export-helper-c27b6911.js";const C={class:"p-6 bg-white border border-gray-200 rounded-lg shadow-md"},k={class:"flex justify-between mb-2"},D=a("h1",{class:"text-indigo-800 font-bold"},"Answers",-1),T=a("div",{class:"border-b border-dashed border-indigo-900 mt-1"},null,-1),A={class:"py-5 space-y-6 divide-y divide-gray-500"},I={class:"flex items-start space-x-6 pt-6"},E={class:"block text-sm font-medium text-gray-700"},F={class:"flex flex-col space-y-2"},M=["onUpdate:modelValue"],P={key:0,class:"flex"},$=["onChange"],B={key:1,class:"flex"},j={class:"flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md"},S={class:"flex flex-1 items-center"},V=a("svg",{class:"h-5 w-5 flex-shrink-0 text-gray-700",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[a("path",{"fill-rule":"evenodd",d:"M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z","clip-rule":"evenodd"})],-1),U={class:"ml-2 flex-1 text-gray-700 text-md"},q={class:"flex ml-4 flex-shrink-0 items-center"},N=["onClick"],O={class:"block text-sm font-medium text-gray-700"},z={class:"flex flex-col space-y-2"},R=["onUpdate:modelValue"],L={key:0,class:"flex flex-wrap gap-2"},G={class:"flex items-center px-3 py-1 rounded-md border border-gray-200 bg-indigo-100 drop-shadow-md"},H={class:"flex flex-1 items-center"},J=a("svg",{class:"h-5 w-5 flex-shrink-0 text-gray-700",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 20 20",fill:"currentColor","aria-hidden":"true"},[a("path",{"fill-rule":"evenodd",d:"M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z","clip-rule":"evenodd"})],-1),K={class:"ml-2 flex-1 text-gray-700 text-md"},Q={class:"flex ml-4 flex-shrink-0 items-center"},W=["onClick"],X={class:"flex"},Y=["onChange"],Z={class:"mt-8"},x={props:{action:String,prop_answers:Object},mounted(){this.init()},data(){return{images_to_delete:[],answers:[],default_answers:[{criterion:{value:"",image_name:"",image_file:""},element:{value:"",images:[]}}]}},methods:{init(){if(this.prop_answers.answers)if(Array.isArray(this.prop_answers.answers))this.answers=this.prop_answers.answers;else{this.prop_answers.answers;{const e=[];for(let s in this.prop_answers.answers)e.push(this.prop_answers.answers[s]);this.answers=e}}else this.answers=this.default_answers},addAnswer(){this.answers.push({criterion:{value:"",image_name:"",image_file:""},element:{value:"",images:[]}})},deleteAnswer(e){this.pushCriterionImageToDelete(e),this.pushElementImagesToDelete(e),this.answers.splice(e,1),this.sendDataToParent()},sendDataToParent(){this.$emit("receivedData",{question_type:3,answers:this.answers,images_to_delete:this.images_to_delete})},openCriterionFileModal(e){this.$refs[e][0].click()},openElementFileModal(e){this.$refs[e][0].click()},handleCriterionFile(e,s){if(e.target.files[0]&&e.target.files[0].type.match(/^image\/(jpeg|png)$/)){const l=e.target.files[0].name.split(".").pop(),t=Date.now().toString()+Math.floor(Math.random()*1e5).toString()+"."+l;this.answers[s].criterion.image_file=new File([e.target.files[0]],t,{type:e.target.files[0].type}),this.answers[s].criterion.image_name=this.answers[s].criterion.image_file.name,this.answers[s].criterion.value='<img class="h-24" src="/storage/diagnostic_test_photo/'+this.answers[s].criterion.image_file.name+'">'}else alert("Only images are allowed!");e.target.value=null,this.sendDataToParent()},handleElementFile(e,s){if(e.target.files[0]&&e.target.files[0].type.match(/^image\/(jpeg|png)$/)){const l=e.target.files[0].name.split(".").pop(),t=Date.now().toString()+Math.floor(Math.random()*1e5).toString()+"."+l;this.answers[s].element.images.push({file:new File([e.target.files[0]],t,{type:e.target.files[0].type}),name:t});const f=this.answers[s].element.images.map(u=>'<img class="h-24" src="/storage/diagnostic_test_photo/'+u.name+'">').join(", ");this.answers[s].element.value=f}else alert("Only images are allowed!");e.target.value=null,this.sendDataToParent()},removeCriterionImage(e){this.correct_answer=[],this.pushCriterionImageToDelete(e),this.clearCriterionAnswerData(e),this.sendDataToParent(e)},removeElementImage(e,s){this.correct_answer=[],this.pushElementImageToDelete(e,s),this.answers[e].element.images.splice(s,1),this.clearElementAnswerData(e),this.sendDataToParent(e)},clearCriterionAnswerData(e){this.answers[e].criterion.image_file="",this.answers[e].criterion.image_name="",this.answers[e].criterion.value=""},clearElementAnswerData(e){if(this.answers[e].element.images.length>0){const l=this.answers[e].element.images.map(n=>'<img class="h-24 w-24" src="/storage/diagnostic_test_photo/'+n.name+'">').join(", ");this.answers[e].element.value=l}else this.answers[e].element.value=""},pushCriterionImageToDelete(e){this.answers[e].criterion&&this.answers[e].criterion.image_name&&this.answers[e].criterion.image_name!=""&&!this.answers[e].criterion.image_file&&this.images_to_delete.push(this.answers[e].criterion.image_name)},pushElementImageToDelete(e,s){this.answers[e].element.images&&this.answers[e].element.images.length>0&&this.answers[e].element.images[s]&&this.answers[e].element.images[s].name!=""&&!this.answers[e].element.images[s].file&&this.images_to_delete.push(this.answers[e].element.images[s].name)},pushElementImagesToDelete(e){this.answers[e].element.images&&this.answers[e].element.images.length>0&&this.answers[e].element.images.map(s=>{this.images_to_delete.push(s.name)})}}},ae=Object.assign(x,{__name:"MatrixSorting",setup(e){return(s,l)=>(r(),o("div",C,[a("div",k,[D,p(g,{onClick:s.addAnswer},{default:h(()=>[m(" Add Answer ")]),_:1},8,["onClick"])]),T,a("div",A,[(r(!0),o(_,null,w(s.answers,(n,t)=>(r(),o("div",I,[a("label",E,[m(" Criterion "),a("div",F,[v(a("textarea",{cols:"1000",class:"focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300","onUpdate:modelValue":i=>s.answers[t].criterion.value=i,onInput:l[0]||(l[0]=(...i)=>s.sendDataToParent&&s.sendDataToParent(...i))},c(n),41,M),[[y,s.answers[t].criterion.value]]),!s.answers[t].criterion.image_file&&!s.answers[t].criterion.image_name?(r(),o("div",P,[a("input",{type:"file",ref_for:!0,ref:"criterion_file_"+t,class:"hidden",onChange:i=>s.handleCriterionFile(i,t)},null,40,$),!s.answers[t].criterion.image_file&&!s.answers[t].criterion.image_name?(r(),b(g,{key:0,buttonType:"info",onClick:i=>s.openCriterionFileModal("criterion_file_"+t),class:"py-1.5 px-2"},{default:h(()=>[m("Upload Image")]),_:2},1032,["onClick"])):d("",!0)])):d("",!0),s.answers[t].criterion.image_file||s.answers[t].criterion.image_name?(r(),o("div",B,[a("div",j,[a("div",S,[V,a("span",U,c(s.answers[t].criterion.image_name),1)]),a("div",q,[a("button",{class:"text-sm font-medium text-red-500 hover:text-red-600",onClick:i=>s.removeCriterionImage(t)}," Remove ",8,N)])])])):d("",!0)])]),a("label",O,[m(" Sort Element "),a("div",z,[v(a("textarea",{cols:"1000",class:"focus:ring-0 focus:border-indigo-300 flex-1 block w-full rounded-md sm:text-sm border-gray-300","onUpdate:modelValue":i=>s.answers[t].element.value=i,onInput:l[1]||(l[1]=(...i)=>s.sendDataToParent&&s.sendDataToParent(...i))},c(n),41,R),[[y,s.answers[t].element.value]]),s.answers[t].element.images.length>0?(r(),o("div",L,[(r(!0),o(_,null,w(s.answers[t].element.images,(i,f)=>(r(),o("div",G,[a("div",H,[J,a("span",K,c(i.name),1)]),a("div",Q,[a("button",{class:"text-sm font-medium text-red-500 hover:text-red-600",onClick:u=>s.removeElementImage(t,f)}," Remove ",8,W)])]))),256))])):d("",!0),a("div",X,[a("input",{type:"file",ref_for:!0,ref:"element_file_"+t,class:"hidden",onChange:i=>s.handleElementFile(i,t)},null,40,Y),p(g,{buttonType:"info",onClick:i=>s.openElementFileModal("element_file_"+t),class:"py-1.5 px-2"},{default:h(()=>[m("Upload Image")]),_:2},1032,["onClick"])])])]),a("div",Z,[p(g,{buttonType:"danger",onClick:i=>s.deleteAnswer(t)},{default:h(()=>[m("Delete")]),_:2},1032,["onClick"])])]))),256))])]))}});export{ae as default};