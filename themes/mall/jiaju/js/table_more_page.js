 
 
function Page(iAbsolute,sTableId,sTBodyId,page)
{
    this.absolute = iAbsolute; //ÿҳ����¼��
    this.tableId = sTableId;
    this.tBodyId = sTBodyId;
    this.rowCount = 0;//��¼��
    this.pageCount = 0;//ҳ��
    this.pageIndex = 0;//ҳ����
    this.__oTable__ = null;//�������
    this.__oTBody__ = null;//Ҫ��ҳ����
    this.__dataRows__ = 0;//��¼������
    this.__oldTBody__ = null;
    this.__init__(); //��ʼ��;
};
/**//*
 ��ʼ��
 */
Page.prototype.__init__ = function(){
    this.__oTable__ = document.getElementById(this.tableId);//��ȡtable����
    this.__oTBody__ = this.__oTable__.tBodies[this.tBodyId];//��ȡtBody����
    this.__dataRows__ = this.__oTBody__.rows;
    this.rowCount = this.__dataRows__.length;
    try{
        this.absolute = (this.absolute <= 0) || (this.absolute>this.rowCount) ? this.rowCount : this.absolute;
        this.pageCount = parseInt(this.rowCount%this.absolute == 0
            ? this.rowCount/this.absolute : this.rowCount/this.absolute+1);
    }catch(exception){}
    this.__updateTableRows__();
};
Page.prototype.GetBar=function(obj)
{
    var bar= document.getElementById(obj.id);
    bar.innerHTML= "ÿҳ"+this.absolute+"��/ҳ"+this.rowCount+"��";// ��2ҳ/��6ҳ ��ҳ ��һҳ 1 2 3 4 5 6 ��һҳ ĩҳ
}
/**//*
 ��һҳ
 */
Page.prototype.nextPage = function(){
    if(this.pageIndex + 1 < this.pageCount){
        this.pageIndex += 1;
        this.__updateTableRows__();
    }
};
/**//*
 ��һҳ
 */
Page.prototype.prePage = function(){
    if(this.pageIndex >= 1){
        this.pageIndex -= 1;
        this.__updateTableRows__();
    }
};
/**//*
 ��ҳ
 */
Page.prototype.firstPage = function(){
    if(this.pageIndex != 0){
        this.pageIndex = 0;
        this.__updateTableRows__();
    }
};
/**//*
 βҳ
 */
Page.prototype.lastPage = function(){
    if(this.pageIndex+1 != this.pageCount){
        this.pageIndex = this.pageCount - 1;
        this.__updateTableRows__();
    }
};
/**//*
 ҳ��λ����
 */
Page.prototype.aimPage = function(){
    var abc = document.getElementById("pageno");
    var iPageIndex = abc.value;
    var iPageIndex = iPageIndex*1;
    if(iPageIndex > this.pageCount-1){
        this.pageIndex = this.pageCount -1;
    }else if(iPageIndex < 0){
        this.pageIndex = 0;
    }else{
        this.pageIndex = iPageIndex-1;
    }
    this.__updateTableRows__();
};
/**//*
 ִ�з�ҳʱ��������ʾ�������
 */
Page.prototype.__updateTableRows__ = function(){
    var iCurrentRowCount = this.absolute * this.pageIndex;
    var iMoreRow = this.absolute+iCurrentRowCount > this.rowCount ? this.absolute+iCurrentRowCount - this.rowCount : 0;
    var tempRows = this.__cloneRows__();
    var removedTBody = this.__oTable__.removeChild(this.__oTBody__);
    var newTBody = document.createElement("TBODY");
    newTBody.setAttribute("id", this.tBodyId);
    for(var i=iCurrentRowCount; i < this.absolute+iCurrentRowCount-iMoreRow; i++){
        newTBody.appendChild(tempRows[i]);
    }
    this.__oTable__.appendChild(newTBody);
    this.__dataRows__ = tempRows;
    this.__oTBody__ = newTBody;
//ҳ����ʾ��
    var divFood = document.getElementById("divFood");//��ҳ������
    divFood.innerHTML="";
    var rightBar = document.createElement("divFood");
    rightBar.setAttribute("display","");
    rightBar.setAttribute("float","left");
    rightBar.innerHTML="��"+(this.pageIndex+1)+"ҳ/��"+this.pageCount+"ҳ";
    var isOK="Y";
    var cssColor="";
    divFood.appendChild(rightBar);
////ҳ����ʾ��ҳ��
};
/**//*
 ��¡ԭʼ�����м���
 */
Page.prototype.__cloneRows__ = function(){
    var tempRows = [];
    for(var i=0; i<this.__dataRows__.length; i++){
        tempRows[i] = this.__dataRows__[i].cloneNode(1);
    }
    return tempRows;
};
