<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import type { ClubNews } from '@/types/news';
import { ArrowUpRight } from 'lucide-vue-next';

defineProps<{ article: ClubNews; featured?: boolean }>();
</script>

<template>
    <Dialog>
        <article
            class="club-news-card"
            :class="{ 'club-news-card--featured': featured, 'club-news-card--photo': !!article.photo }"
            :aria-labelledby="`news-${article.id}`"
        >
            <div
                v-if="featured || article.photo"
                class="club-news-card__visual"
                :class="{ 'club-news-card__visual--photo': !!article.photo }"
                aria-hidden="true"
            >
                <img :src="article.photo || '/images/club-logo.png'" alt="" width="526" height="526" />
                <span v-if="article.score && !article.photo" class="club-news-card__score">{{ article.score }}</span>
                <span v-if="article.opponent && !article.photo" class="club-news-card__fixture"
                    >FC Hymont <span>vs</span> {{ article.opponent }}</span
                >
            </div>
            <div class="club-news-card__content">
                <div class="club-news-card__meta">
                    <span>{{ article.day }} {{ article.month }}</span
                    ><span>{{ article.category }}</span>
                </div>
                <h2 :id="`news-${article.id}`">{{ article.title }}</h2>
                <p>{{ article.excerpt }}</p>
                <DialogTrigger as-child>
                    <Button variant="ghost" class="club-news-card__action" :aria-label="`Lire l’article : ${article.title}`">
                        Lire l’article<ArrowUpRight :size="18" aria-hidden="true" />
                    </Button>
                </DialogTrigger>
            </div>
        </article>
        <DialogContent class="club-theme club-news-dialog">
            <DialogDescription class="club-news-dialog__meta">{{ article.day }} {{ article.month }} · {{ article.category }}</DialogDescription>
            <DialogTitle class="club-news-dialog__title">{{ article.title }}</DialogTitle>
            <img v-if="article.photo" :src="article.photo" :alt="article.title" class="club-news-dialog__photo" />
            <div class="club-news-dialog__body">
                <p v-for="paragraph in article.paragraphs" :key="paragraph">{{ paragraph }}</p>
            </div>
        </DialogContent>
    </Dialog>
</template>
