from django.db import models

# Create your models here.


class locationData(models.Model):

    site_id = models.IntegerField(primary_key=True, db_column='site_id')

    site_name = models.CharField(max_length=255, db_column='site_name')

    county = models.CharField(max_length=45, db_column='county')

    class Meta:
        managed = False       # Prevents Django from managing migrations for this table
        db_table = 'location'  # The exact table name in your schema
