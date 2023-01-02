<body>

    <!-- other html -->
    Hi
    <button id="call">call</button>
    <script omi-sdk type="text/javascript" src="https://cdn.omicrm.com/sdk/2.0.0/sdk.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Ví dụ về một số config có thể dùng khi init SDK
            let config = {
                theme: 'default',
                callbacks: {
                    register: (data) => {
                        // Sự kiện xảy ra khi trạng thái kết nối tổng đài thay đổi
                        console.log('register:', data);
                    },
                    connecting: (data) => {
                        // Sự kiện xảy ra khi bắt đầu thực hiện cuộc gọi ra
                        console.log('connecting:', data);
                    },
                    invite: (data) => {
                         // Sự kiện xảy ra khi có cuộc gọi tới
                         console.log('invite:', data);
                    },
                    inviteRejected: (data) => {
                         // Sự kiện xảy ra khi có cuộc gọi tới, nhưng bị tự động từ chối
                         // trong khi đang diễn ra một cuộc gọi khác
                         console.log('inviteRejected:', data);
                    },
                    ringing: (data) => {
                        // Sự kiện xảy ra khi cuộc gọi ra bắt đầu đổ chuông
                        console.log('ringing:', data);
                    },
                    accepted: (data) => {
                         // Sự kiện xảy ra khi cuộc gọi vừa được chấp nhận
                         console.log('accepted:', data);
                    },
                    incall: (data) => {
                         // Sự kiện xảy ra mỗi 1 giây sau khi cuộc gọi đã được chấp nhận
                         console.log('incall:', data);
                    },
                    acceptedByOther: (data) => {
                         // Sự kiện dùng để kiểm tra xem cuộc gọi bị kết thúc
                         // đã được chấp nhận ở thiết bị khác hay không
                         console.log('acceptedByOther:', data);
                    },
                    ended: (data) => {
                         // Sự kiện xảy ra khi cuộc gọi kết thúc
                         console.log('ended:', data);
                    },
                    holdChanged: (status) => {
                         // Sự kiện xảy ra khi trạng thái giữ cuộc gọi thay đổi
                         console.log('on hold:', status);
                    },
                    saveCallInfo: (data) => {
                        // let { callId, note, ...formData } = data;
                        // Sự kiện xảy ra khi cuộc gọi đã có đổ chuông hoặc cuộc gọi tới, khi user có nhập note input mặc định hoặc form input custom
                        console.log('on save call info:', data);
		    },
                }
            };
            omiSDK.init(config, () => {
                // nếu url login của bạn là: https://abc.omicall.com
                // và số nội bộ của bạn là 100 với password là 123456
                // thì param khi register sẽ là:
                // omiSDK.register({
                //    domain: 'abc',
                //    username: '100', 
                //    password: '123456'
                // });
                omiSDK.register({
                    domain: 'thangvx',
                    username: '100', // tương đương trường "sip_user" trong thông tin số nội bộ
                    password: 'W0zrZNAo8Q'
                });
            });
        });
        call = document.getElementById('call')
        call.onclick = function(){
            omiSDK.makeCall("0368505826")
        };
    </script>

</body>