<template>
    <div class="error-page">
        <div class="particles">
            <!-- Particles will be generated via JavaScript -->
        </div>

        <div class="error-container">
            <h1 class="error-number">404</h1>
            <h2 class="error-title">Page Not Found</h2>
            <p class="error-text">
                We apologize for the inconvenience. The page you're looking for might be temporarily unavailable 
                or part of our upcoming features. We're constantly improving our system to serve you better.
                <br>Meanwhile, let us assist you in getting back on track.
            </p>
            <div class="button-group">
               

                <a href="/dashboard" class="back-button">
                    <i class="fas fa-home"></i>
                    Back to Dashboard
                </a>
                <a :href="whatsappLink" target="_blank" class="feedback-button">
                    <i class="fab fa-whatsapp"></i>
                    We Love Your Feedback
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'NotFoundComponent',
    data() {
        return {
            whatsappLink: 'https://wa.me/+254781312070?text=Hi,%20I%20found%20a%20404%20error%20on%20your%20website.%20I%20was%20looking%20for...'
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
body {
    background: #f8f9fe;
    font-family: 'Inter', sans-serif;
    color: #525f7f;
    margin: 0;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.error-container {
    text-align: center;
    padding: 40px 20px;
    max-width: 600px;
    position: relative;
}

.error-number {
    font-size: 180px;
    line-height: 1;
    font-weight: 700;
    color: #5e72e4;
    text-shadow: 4px 4px 8px rgba(94, 114, 228, 0.2);
    margin: 0;
    animation: float 6s ease-in-out infinite;
}

.error-title {
    font-size: 28px;
    font-weight: 600;
    color: #32325d;
    margin: 20px 0;
}

.error-text {
    font-size: 16px;
    color: #8898aa;
    margin-bottom: 30px;
    line-height: 1.6;
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

.back-button i, .feedback-button i {
    margin-right: 8px;
    font-size: 1.1em;
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
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
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

/* Generate particles with Vue */
.particle {
    width: 10px;
    height: 10px;
    background: rgba(94, 114, 228, 0.5);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .error-number {
        font-size: 140px;
    }

    .error-title {
        font-size: 24px;
    }

    .error-text {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .error-number {
        font-size: 100px;
    }

    .button-group {
        flex-direction: column;
        gap: 10px;
    }

    .back-button, .feedback-button {
        width: 100%;
        justify-content: center;
    }
}

.error-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fe;
    position: relative;
    overflow: hidden;
}
</style> 