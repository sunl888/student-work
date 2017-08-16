let diff = {
    save(oldObj) {
        this.oldObj = {...oldObj};      
    },
    diff(newObj) {
        if(this.oldObj == {} || this.oldObj == undefined) {
            return newObj;
        }
        let diffObj = {};
        for (var key in newObj) {
            if(isValue(this.oldObj[key])) {
                if(this.oldObj[key] != newObj[key]) {
                    diffObj[key] = newObj[key];
                }
            }else if(isArray(this.oldObj[key])) {
                if(this.oldObj[key].sort().toString() != newObj[key].sort().toString()) {
                    diffObj[key] = newObj[key];
                }
            }
        }
        this.oldObj = {};
        return diffObj;
    }
}
function isArray(obj) 
{
    return {}.toString.apply(obj) === '[object Array]';
}
function isObject(obj) 
{
    return {}.toString.apply(obj) === '[object Object]';
}
function isValue(obj) 
{
    return !isObject(obj) && !isArray(obj);
}

module.exports = diff;
export default diff