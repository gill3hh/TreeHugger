from django.contrib import admin
from .models import Plant


# this is my django administration interface where i can see the data stored in database. so that i can interact with my data.
class PlantAdmin(admin.ModelAdmin):
    list_display = ('name', 'user')

admin.site.register(Plant)
# Register your models here.
