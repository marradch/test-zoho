<template>
    <div v-if="error" class="alert alert-danger mt-2" role="alert">
        {{ error }}
    </div>

    <div v-if="success" class="alert alert-success mt-2" role="alert">
        Account & Deal sucessfully created
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Creation of account & deal</div>
                <div class="card-body">
                    <form method="POST" @submit.prevent="createAccountDeal">
                        <div class="form-group">
                            <label for="dealName">Deal Name</label>
                            <input type="text" class="form-control" id="dealName" v-model="accountDeal.dealName">
                            <span v-if="accountDealErrors.dealName" class="text-danger">{{ accountDealErrors.dealName }}</span>
                        </div>
                        <div class="form-group">
                            <label for="dealStage">Deal Stage</label>
                            <select id="dealStage" class="form-select" v-model="accountDeal.dealStage">
                                <option value=""></option>
                                <option value="Qualification">Qualification</option>
                                <option value="Needs Analysis">Needs Analysis</option>
                                <option value="Value Proposition">Value Proposition</option>
                                <option value="Identify Decision Makers">Identify Decision Makers</option>
                                <option value="Proposal/Price Quote">Proposal/Price Quote</option>
                                <option value="Negotiation/Review">Negotiation/Review</option>
                                <option value="Closed Won">Closed Won</option>
                                <option value="Closed Lost">Closed Lost</option>
                                <option value="Closed Lost to Competition">Closed Lost to Competition</option>
                            </select>
                            <span v-if="accountDealErrors.dealStage" class="text-danger">{{ accountDealErrors.dealStage }}</span>
                        </div>
                        <div class="form-group">
                            <label for="accountName">Account Name</label>
                            <input type="text" class="form-control" id="accountName" v-model="accountDeal.accountName">
                            <span v-if="accountDealErrors.accountName" class="text-danger">{{ accountDealErrors.accountName }}</span>
                        </div>
                        <div class="form-group">
                            <label for="accountWebsite">Account Website</label>
                            <input type="text" class="form-control" id="accountWebsite" v-model="accountDeal.accountWebsite">
                            <span v-if="accountDealErrors.accountWebsite" class="text-danger">{{ accountDealErrors.accountWebsite }}</span>
                        </div>
                        <div class="form-group">
                            <label for="accountPhone">Account Phone</label>
                            <input type="text" class="form-control" id="accountPhone" v-model="accountDeal.accountPhone">
                            <span v-if="accountDealErrors.accountPhone" class="text-danger">{{ accountDealErrors.accountPhone }}</span>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            error: '',
            success: false,
            accountDeal: {
                dealName: '',
                dealStage: '',
                accountName: '',
                accountWebsite: '',
                accountPhone: '',
            },
            accountDealErrors: {
                dealName: '',
                dealStage: '',
                accountName: '',
                accountWebsite: '',
                accountPhone: '',
            },
        }
    },
    methods: {
        isValid() {
            this.accountDealErrors = {
                dealName: '',
                dealStage: '',
                accountName: '',
                accountWebsite: '',
                accountPhone: '',
            };

            if (!this.accountDeal.dealName.trim()) {
                this.accountDealErrors.dealName = 'Deal Name is required';
            }

            if (!this.accountDeal.accountName.trim()) {
                this.accountDealErrors.accountName = 'Account Name is required';
            }

            if (this.accountDeal.accountWebsite.trim() && !/^https?:\/\/[a-zA-Z0-9_-]+\.[a-zA-Z0-9.-]+$/i.test(this.accountDeal.accountWebsite)) {
                this.accountDealErrors.accountWebsite = 'Invalid website format';
            }

            if (this.accountDeal.accountPhone.includes('_')) {
                this.accountDealErrors.accountPhone = 'Phone should not contain "_"';
            }

            const isValid = Object.values(this.accountDealErrors).every(error => error === '');

            return isValid;
        },
        createAccountDeal() {
            this.error = '';
            this.success = false;

            if (!this.isValid()) {
                return;
            }

            var component = this;
            axios.post('/api/create-account-and-deal',{
                dealName: this.accountDeal.dealName,
                dealStage: this.accountDeal.dealStage,
                accountName: this.accountDeal.accountName,
                accountWebsite: this.accountDeal.accountWebsite,
                accountPhone: this.accountDeal.accountPhone,
            })
                .then(function (response) {
                    if (response.data.status == 'success') {
                        component.success = true;
                        this.accountDeal = {
                            dealName: '',
                            dealStage: '',
                            accountName: '',
                            accountWebsite: '',
                            accountPhone: '',
                        };
                    }
                })
                .catch(function (error) {
                    if (error.response) {
                        if (error.response.status === 500 || error.response.status === 422) {
                            component.error = error.response.data.message;
                        } else {
                            component.error = 'An error occurred. Please try again later.';
                        }
                    }
                });
        },
    }
}
</script>
