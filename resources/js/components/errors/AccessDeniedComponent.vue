<template>
    <div class="error-page">
        <div class="particles">
            <!-- Particles will be generated via JavaScript -->
        </div>

        <div class="error-container">
            <div class="lock-animation">
                <i class="fas fa-lock"></i>
            </div>
            <h1 class="error-number">403</h1>
            <h2 class="error-title">Access Denied</h2>
            <p class="error-text">
                We apologize, but you don't have the necessary permissions to access this area. 
                This might be due to:
            </p>
            <ul class="error-reasons">
                <li><i class="fas fa-key"></i> Insufficient access rights</li>
                <li><i class="fas fa-clock"></i> Temporary restriction</li>
                <li><i class="fas fa-user-shield"></i> Security protocol</li>
            </ul>
            <p class="error-help">
                If you believe this is an error, please contact your system administrator 
                or reach out to our support team for assistance.
            </p>
            <div class="button-group">
                <a href="/pos" class="back-button">
                    <i class="fas fa-cash-register"></i>
                    Proceed to Cash Register
                </a>
                <a :href="whatsappLink" target="_blank" class="feedback-button">
                    <i class="fab fa-whatsapp"></i>
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AccessDeniedComponent',
    data() {
        return {
            whatsappLink: 'https://wa.me/+254781312070?text=Hi,%20I%20need%20help%20with%20accessing%20a%20restricted%20area%20in%20the%20system.'
        }
    },
    mounted() {
        this.createParticles();
    },
    methods: {
        createParticles() {
            const particles = document.querySelector('.particles');
            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particles.appendChild(particle);
            }
        }
    }
}
</script>

<style scoped>
.error-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fe;
    position: relative;
    overflow: hidden;
}

.error-container {
    text-align: center;
    padding: 40px 20px;
    max-width: 600px;
    position: relative;
}

.lock-animation {
    font-size: 64px;
    color: #dc3545;
    margin-bottom: 20px;
    animation: shake 0.5s ease-in-out infinite;
}

.error-number {
    font-size: 120px;
    line-height: 1;
    font-weight: 700;
    color: #dc3545;
    text-shadow: 4px 4px 8px rgba(220, 53, 69, 0.2);
    margin: 0;
}

.error-title {
    font-size: 32px;
    font-weight: 600;
    color: #32325d;
    margin: 20px 0;
}

.error-text {
    font-size: 16px;
    color: #8898aa;
    margin-bottom: 20px;
    line-height: 1.6;
}

.error-reasons {
    list-style: none;
    padding: 0;
    margin: 0 0 30px;
    text-align: left;
    display: inline-block;
}

.error-reasons li {
    margin: 10px 0;
    color: #525f7f;
    font-size: 16px;
    display: flex;
    align-items: center;
}

.error-reasons li i {
    margin-right: 10px;
    color: #dc3545;
    width: 20px;
}

.error-help {
    font-size: 14px;
    color: #8898aa;
    margin-bottom: 30px;
    font-style: italic;
}

.button-group {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.back-button, .feedback-button {
    display: inline-flex;
    align-items: center;
    padding: 12px 30px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.back-button {
    background: #5e72e4;
    color: white;
}

.feedback-button {
    background: #25D366;
    color: white;
}

.back-button:hover {
    background: #4557c9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(94, 114, 228, 0.3);
    color: white;
    text-decoration: none;
}

.feedback-button:hover {
    background: #128C7E;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    color: white;
    text-decoration: none;
}

.particles {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.particle {
    position: absolute;
    border-radius: 50%;
    animation: float-particle 8s infinite;
    opacity: 0.5;
    background: rgba(220, 53, 69, 0.2);
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

@keyframes float-particle {
    0%, 100% {
        transform: translate(0, 0);
        opacity: 0.5;
    }
    50% {
        transform: translate(20px, -20px);
        opacity: 0.8;
    }
}

@media (max-width: 768px) {
    .error-number {
        font-size: 100px;
    }

    .error-title {
        font-size: 28px;
    }

    .error-reasons {
        padding: 0 20px;
    }
}

@media (max-width: 480px) {
    .button-group {
        flex-direction: column;
        gap: 10px;
    }

    .back-button, .feedback-button {
        width: 100%;
        justify-content: center;
    }
}
</style> 