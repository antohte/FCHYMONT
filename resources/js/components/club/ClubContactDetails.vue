<script setup lang="ts">
import type { ContactDetails } from '@/types/content';
import { ArrowUpRight, MapPin, Phone } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{ details: ContactDetails | null }>();
const contacts = computed(() =>
    (
        props.details?.entries ??
        [1, 2].map((i) => ({
            name: (props.details?.[`contact${i}_name` as keyof ContactDetails] as string) || '',
            phone: (props.details?.[`contact${i}_phone` as keyof ContactDetails] as string) || '',
        }))
    )
        .filter((contact) => contact.phone)
        .map((contact) => ({ name: contact.name || '', phone: contact.phone, href: `tel:${contact.phone.replace(/[^+0-9]/g, '')}` })),
);
const address = computed(() => props.details?.address?.split('\n') ?? []);
</script>

<template>
    <div class="club-contact-details">
        <section class="club-contact-details__address" aria-labelledby="contact-address">
            <MapPin class="club-contact-details__icon" :size="28" aria-hidden="true" />
            <h2 id="contact-address">Adresse</h2>
            <address>
                <span v-for="(line, index) in address" :key="index">{{ line }}</span>
            </address>
        </section>
        <section class="club-contact-details__phones" aria-labelledby="contact-phones">
            <Phone class="club-contact-details__icon" :size="28" aria-hidden="true" />
            <h2 id="contact-phones">Téléphone</h2>
            <ul>
                <li v-for="contact in contacts" :key="contact.href">
                    <a :href="contact.href" :aria-label="`Appeler ${contact.name} au ${contact.phone}`"
                        ><span
                            ><strong>{{ contact.name }}</strong
                            ><span>{{ contact.phone }}</span></span
                        ><ArrowUpRight :size="22" aria-hidden="true"
                    /></a>
                </li>
            </ul>
        </section>
    </div>
</template>
