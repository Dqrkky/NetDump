class DateTime {
    constructor(url="http://localhost:8000/datetime.php?format=json") {
        this.config = {
            xhr: new XMLHttpRequest(),
            url: (url && typeof url === 'string') ? url : null
        }
        if (this.config.url) {
            this.config.xhr.open('GET', url, true);
            this.config.xhr.send();
            this.config.xhr.onreadystatechange = this.onreadystate
        }
    }
    onreadystate = () => {
        if (this.config.xhr.readyState === XMLHttpRequest.LOADING) {
            var response = this.config.xhr.responseText.split("\n")
            var data = JSON.parse(response[response.length - 2])
            if (this.onchangetime && data?.data?.time) this.onchangetime(data?.data?.time)
            if (this.onchangedate && data?.data?.date) this.onchangedate(data?.data?.date)
        }
    }
}

export default {
    DateTime
}