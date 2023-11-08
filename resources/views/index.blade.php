<script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<div id="liffId" style="display: none">{{ $token }}</div>
<div id="productId" style="display: none">{{ $id }}</div>
<script type="text/javascript">
		liffId = $("#liffId").text();
		productId = $("#productId").text();
		if(productId != ''){
			axios.post('/front/setProductId', {'productId': productId})
		}
		liff.init({
			liffId: liffId
		})
		.then(() => {
			if(liff.isLoggedIn()){
				token = liff.getAccessToken();
				axios.post('/front/setToken', {'token': token, 'liffId': liffId})
				.then((res) => {
					window.location.href='/front/login';
				})
			}else{
				axios.post('/front/setToken', {'liffId': liffId})
				window.location.href='https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=2000777378&redirect_uri=https://groupbuy.learning365.tw/front/login&state=12345abcde&scope=openid%20profile&nonce=09876xyz'
			}
		})
		.catch(() => {
			console.error('errrror')
		})
</script>