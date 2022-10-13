import axios from 'axios'
import $ from 'jquery'

export const api = {
    async get(url) {            
      let resp =  await axios
                        .get(url)
                        .then(this.sleeper(500))
                        .then(res => res.data)
                        .catch(error => error)
      
      return resp
    },
    async post(url, formData) {
      let resp = await axios
                      .post(url, formData)
                      .then(this.sleeper(500))
                      .then(res => {
                        console.log(res)
                      })
                      .catch(error => error)

      return resp
    },
    ajaxPost(url, formData) {
      let resp =  $.ajax({
                      url: url,
                      type: 'post',
                      data: formData,
                      processData: false,
                      contentType: false,
                      success: function (res) {
                        console.log(res)
                      }
                    })

      return resp
    },
    sleeper(ms) {
       return function(x) {
        return new Promise(resolve => setTimeout(() => resolve(x), ms))
      }
    }
}
