function getUser() {
   return fetch('https://perenual.com/api/species-list?key=sk-69p865beb721925be4020', {
     method: 'POST',
     body: JSON.stringify({
       author: 'bobby hadz',
       title: 'Using fetch correctly in JavaScript',
     }),
     headers: {
       Accept: 'application/json',
       Authorization: 'common_name sk-69p865beb721925be4020',
       'Content-Type': 'application/json',
     },
   })
     .then(response => {
       if (!response.ok) {
         throw new Error(`Error! status: ${response.status}`);
       }
 
       return response.json();
     })
     .catch(error => {
       console.log('error: ', error);
     });
 }
 
 getUser().then(data => {
   console.log(data);
 });
 