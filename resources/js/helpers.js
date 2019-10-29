export function errorsHandler(self, errors) {
    self.loading = false;
    if(errors.response.data.errors) {
        let first = true;
        Object.keys(errors.response.data.errors).forEach(key => {

            const error = errors.response.data.errors[key];
            const field = self.$validator.fields.find({name: key, scope: self.$options.scope});
            try {
                if (field.id) {

                    self.$validator.errors.add({
                        id: field.id,
                        field: key,
                        msg: error.join(' '),
                        scope: self.$options.scope,
                    });

                    field.setFlags({
                        invalid: true,
                        valid: false,
                        validated: true,
                    });

                    if (first) {
                        field.el.scrollIntoView({block: "center", behavior: "smooth"});
                        first = false;
                    }
                } else {
                    console.log('field ' + key + ' not found.')
                }
            } catch (e) {
                console.log(e)
            }
        });
    }
}
